<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
require_once __DIR__ . '/php/conexion.php';

$uid = (int)$_SESSION['usuario_id'];
$u = ['nombre' => $_SESSION['usuario_nombre'], 'consultorio' => $_SESSION['usuario_consultorio']];

$id = (int)($_GET['id'] ?? 0);
$res = mysqli_query($conexion, "SELECT *, TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad FROM pacientes WHERE id=$id AND usuario_id=$uid");
$p = mysqli_fetch_assoc($res);
if (!$p) { http_response_code(404); exit('Paciente no encontrado.'); }

$res = mysqli_query($conexion, "SELECT h.*, pr.nombre AS procedimiento FROM historias h JOIN procedimientos pr ON pr.id = h.procedimiento_id WHERE h.paciente_id=$id ORDER BY h.fecha ASC, h.id ASC");
$consultas = [];
while ($fila = mysqli_fetch_assoc($res)) { $consultas[] = $fila; }

$fmt = fn($f) => date('d/m/Y', strtotime($f));
$sexos = ['F' => 'Femenino', 'M' => 'Masculino', 'O' => 'Otro'];
$nombreArchivo = 'historia_' . preg_replace('/[^A-Za-z0-9_-]/', '', $p['cedula']) . '.pdf';

$rutaFpdf = __DIR__ . '/includes/fpdf/fpdf.php';

if (file_exists($rutaFpdf)) {
    // ---------- PDF con FPDF ----------
    require $rutaFpdf;

    // FPDF trabaja en ISO-8859-1/Windows-1252: convertimos los textos UTF-8
    function t($s) {
        $r = @iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', (string)$s);
        return $r === false ? '' : $r;
    }

    class HistoriaPDF extends FPDF {
        public $consultorio = '';
        public $medico = '';
        public $pie = '';

        function Header() {
            $this->SetFillColor(14, 42, 71);
            $this->Rect(0, 0, 210, 28, 'F');
            $this->SetTextColor(255, 255, 255);
            $this->SetFont('Arial', 'B', 20);
            $this->SetXY(15, 7);
            $this->Cell(90, 9, 'Muelitas App');
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(243, 230, 211);
            $this->SetXY(120, 8);
            $this->Cell(75, 7, 'HISTORIA CLINICA', 0, 0, 'R');
            $this->SetFont('Arial', '', 9);
            $this->SetXY(15, 17);
            $this->Cell(120, 6, $this->consultorio . '  -  Dr(a). ' . $this->medico);
            $this->SetTextColor(255, 255, 255);
            $this->SetXY(120, 17);
            $this->Cell(75, 6, 'Emitida el ' . date('d/m/Y'), 0, 0, 'R');
            $this->SetY(36);
        }

        function Footer() {
            $this->SetY(-14);
            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(91, 107, 123);
            $this->Cell(0, 8, $this->pie . '  -  Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
        }
    }

    $pdf = new HistoriaPDF('P', 'mm', 'A4');
    $pdf->consultorio = t($u['consultorio']);
    $pdf->medico = t($u['nombre']);
    $pdf->pie = t('Muelitas App - ' . $p['nombres'] . ' ' . $p['apellidos']);
    $pdf->AliasNbPages();
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->AddPage();

    // Datos del paciente
    $pdf->SetTextColor(11, 31, 51);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 9, t($p['nombres'] . ' ' . $p['apellidos']), 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(91, 107, 123);
    $pdf->MultiCell(0, 5.5, t('Cédula: ' . $p['cedula'] . '   |   Edad: ' . $p['edad'] . ' años   |   Sexo: ' . ($sexos[$p['sexo']] ?? '') . '   |   Nacimiento: ' . $fmt($p['fecha_nacimiento'])));
    if ($p['telefono'] !== '')  $pdf->MultiCell(0, 5.5, t('Teléfono: ' . $p['telefono']));
    if ($p['direccion'] !== '') $pdf->MultiCell(0, 5.5, t('Dirección: ' . $p['direccion']));
    $pdf->Ln(3);

    foreach ([['Alergias', $p['alergias'], 'Ninguna registrada'], ['Antecedentes', $p['antecedentes'], 'Sin antecedentes registrados']] as [$titulo, $valor, $vacio]) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(11, 31, 51);
        $pdf->Cell(0, 6, t($titulo), 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(91, 107, 123);
        $pdf->MultiCell(0, 5.5, t($valor !== '' ? $valor : $vacio));
        $pdf->Ln(2);
    }

    $pdf->SetDrawColor(214, 227, 238);
    $pdf->Line(15, $pdf->GetY() + 1, 195, $pdf->GetY() + 1);
    $pdf->Ln(6);

    // Consultas
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->SetTextColor(11, 31, 51);
    $pdf->Cell(0, 8, t('Consultas y procedimientos (' . count($consultas) . ')'), 0, 1);
    $pdf->Ln(1);

    if (!$consultas) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(91, 107, 123);
        $pdf->Cell(0, 6, t('Este paciente aún no tiene consultas registradas.'), 0, 1);
    }
    foreach ($consultas as $c) {
        if ($pdf->GetY() > 255) $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(11, 31, 51);
        $pdf->MultiCell(0, 6, t($fmt($c['fecha']) . '  -  ' . $c['procedimiento'] . ($c['pieza_dental'] !== '' ? '  -  Pieza ' . $c['pieza_dental'] : '')));
        $pdf->SetFont('Arial', '', 10);
        foreach ([['Motivo', $c['motivo']], ['Diagnóstico', $c['diagnostico']], ['Observaciones', $c['observaciones']]] as [$etq, $txt]) {
            if ($txt === '') continue;
            $pdf->SetTextColor(91, 107, 123);
            $pdf->SetX(21);
            $pdf->MultiCell(0, 5.5, t($etq . ': ' . $txt));
        }
        $pdf->Ln(4);
    }

    $pdf->Output('I', $nombreArchivo);
    exit;
}

// Falta la librería: avisamos con claridad en lugar de mostrar un error técnico
http_response_code(500);
exit('Falta la librería FPDF. Copia fpdf.php en includes/fpdf/fpdf.php (descárgala en https://www.fpdf.org).');
