# 🦷 Muelitas App - Historia clínica odontológica

> 🎓 **Proyecto académico / educativo**
> Aplicación web para llevar la historia clínica de los pacientes de un consultorio odontológico, desarrollada con PHP, MySQL, AJAX y Bootstrap.

[![PHP](https://img.shields.io/badge/PHP-7.4%20%7C%208.x-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-4.6-563D7C?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com/docs/4.6/)
[![jQuery](https://img.shields.io/badge/jQuery-3.6.0-0769AD?style=flat-square&logo=jquery&logoColor=white)](https://jquery.com/)

Permite al odontólogo registrar a sus pacientes, los procedimientos que ofrece (limpieza, blanqueo, extracción de muelas y cordales, tratamiento de conductos, calzas), llevar la historia clínica de cada paciente y descargarla en PDF.

<!--
Vista previa: toma una captura del panel, guárdala como assets/img/panel.png
y quita las marcas de comentario de la línea siguiente.
![Vista previa de la aplicación](assets/img/panel.png)
-->

---

## ✨ Funcionalidades

- **Inicio de sesión y registro** de odontólogos (cada uno ve solo sus propios datos).
- **Panel principal** con contadores (pacientes, consultas del mes, procedimientos activos) y las últimas consultas.
- **Menú de opciones** para moverse entre Inicio, Pacientes, Historias clínicas y Procedimientos.
- **CRUD de pacientes:** registrar, buscar, editar y eliminar. Guarda cédula, fecha de nacimiento, sexo, teléfono, dirección, alergias y antecedentes.
- **CRUD de procedimientos:** crear, editar, activar o desactivar y eliminar, con descripción y precio.
- **CRUD de consultas:** agregar, editar y eliminar consultas dentro de la historia clínica de cada paciente (fecha, pieza dental, motivo, diagnóstico y observaciones).
- **Historia clínica en PDF** de cada paciente.
- **AJAX con jQuery:** las tablas y los formularios se actualizan sin recargar la página.

---

## 🛠️ Tecnologías utilizadas

| Capa | Tecnología |
|---|---|
| Frontend | HTML5, CSS3, Bootstrap 4.6, Font Awesome 4.7 y jQuery 3.6 |
| Backend | PHP con la extensión MySQLi |
| Base de datos | MySQL / MariaDB (InnoDB, `utf8mb4`) |
| Comunicación | AJAX (`$.ajax`) con respuestas JSON (`exito` / `error`) |
| PDF | [FPDF](http://www.fpdf.org/) |

---

## 📁 Estructura del proyecto

```
muelitas/
│
├── index.php             # Portada
├── login.php             # Inicio de sesión
├── registro.php          # Crear cuenta
├── panel.php             # Panel principal
├── pacientes.php         # Lista y CRUD de pacientes
├── paciente.php          # Historia clínica de un paciente
├── historias.php         # Lista de historias clínicas
├── procedimientos.php    # CRUD de procedimientos
├── historia_pdf.php      # Genera la historia clínica en PDF
├── logout.php            # Cerrar sesión
├── database.sql          # Base de datos para XAMPP (local)
├── database_hosting.sql  # Base de datos para hosting (sin CREATE DATABASE)
│
├── includes/
│   ├── header.php        # Menú de navegación y cabecera
│   ├── footer.php        # Pie de página y scripts
│   ├── fotos.php         # Función para mostrar las fotos
│   └── fpdf/             # Librería FPDF (fpdf.php y carpeta font/)
│
├── assets/
│   ├── css/app.css       # Estilos propios
│   ├── js/               # Peticiones AJAX con jQuery (una por página)
│   └── img/              # Fotos de la aplicación
│
└── php/
    ├── conexion.php      # Conexión MySQLi y funciones comunes
    ├── config.example.php# Plantilla de datos de conexión
    ├── config.php        # Datos reales de conexión (NO se sube a GitHub)
    ├── seguridad.php     # Exige sesión iniciada
    ├── login.php / registro.php
    ├── pacientes_*.php       # listar, seleccionar, agregar, editar, eliminar
    ├── procedimientos_*.php  # listar, seleccionar, agregar, editar, eliminar, alternar
    └── consultas_*.php       # listar, seleccionar, agregar, editar, eliminar
```

---

## 🗄️ Base de datos

Cuatro tablas relacionadas con claves foráneas:

| Tabla | Descripción |
|---|---|
| `usuarios` | Odontólogos que usan la aplicación |
| `pacientes` | Pacientes de cada odontólogo (cédula única por odontólogo) |
| `procedimientos` | Procedimientos que ofrece cada odontólogo, con precio |
| `historias` | Consultas de cada paciente, ligadas a un procedimiento |

Al eliminar un paciente se eliminan también sus consultas (`ON DELETE CASCADE`). Un procedimiento que ya se usó en alguna consulta no se puede eliminar; en ese caso se desactiva.

---

## ⚙️ Instalación local (XAMPP)

### Requisitos
- XAMPP, WAMP, Laragon o similar (Apache + PHP 7.4 o superior + MySQL/MariaDB).

### Pasos

1. **Copia el proyecto** a la carpeta `htdocs` de XAMPP:
   ```
   C:\xampp\htdocs\muelitas
   ```
2. **Crea la base de datos:** abre phpMyAdmin (`http://localhost/phpmyadmin`), ve a *Importar* y selecciona `database.sql`. Se crea la base `muelitas_app` con sus tablas.
3. **Configura la conexión:** copia `php/config.example.php` como `php/config.php`. Los valores por defecto de XAMPP ya funcionan:
   ```php
   $servidor = "localhost";
   $usuario = "root";
   $password = "";
   $base_datos = "muelitas_app";
   ```
4. **Instala FPDF** (necesario para el PDF): descarga la librería desde [fpdf.org](http://www.fpdf.org/) y copia **`fpdf.php` y la carpeta `font/`** dentro de `includes/fpdf/`.
5. **Agrega las fotos** en `assets/img/` (ver la sección *Fotos*).
6. **Abre la aplicación** en `http://localhost/muelitas/` y crea tu cuenta.

---

## 🌐 Instalación en un hosting gratuito (InfinityFree)

1. Crea la base de datos desde el panel del hosting (*MySQL Databases*) y anota el host, el nombre, el usuario y la contraseña.
2. En phpMyAdmin, entra a esa base e importa **`database_hosting.sql`** (no `database.sql`, porque el hosting no permite `CREATE DATABASE`).
3. Crea `php/config.php` con los datos del hosting.
4. Sube el contenido del proyecto por FTP a la carpeta `htdocs`.

---

## 🔒 Seguridad

- Contraseñas guardadas con `password_hash()` y verificadas con `password_verify()`.
- Los textos se limpian con `mysqli_real_escape_string` y los identificadores se convierten con `(int)` antes de usarse en SQL.
- Los datos que se muestran en pantalla se escapan con `htmlspecialchars` (función `e()`) o con `esc()` en JavaScript.
- Todas las consultas filtran por el `usuario_id` de la sesión, así que un odontólogo no puede ver ni modificar los datos de otro.
- Los archivos de `php/` exigen sesión iniciada (`seguridad.php`) y devuelven un error 401 si ha expirado.
- Los datos de conexión viven en `php/config.php`, que está en `.gitignore` y no se sube al repositorio.

> ⚠️ **Este es un proyecto académico.** No lo uses con datos reales de pacientes.

---

## 📷 Fotos

Las fotos se buscan en `assets/img/` con estos nombres. Si un archivo no existe, la página intenta cargar la misma foto desde Unsplash.

| Archivo | Foto |
|---|---|
| `hero.jpg` | [Consultorio dental](https://unsplash.com/photos/a-dental-room-with-a-blue-chair-and-dental-equipment-AQG6C_xYEpA) |
| `consulta.jpg` | [Dentista examinando a un paciente](https://unsplash.com/photos/dentist-examining-patient-in-dental-office-rm7Mgu33tHU) |
| `paciente.jpg` | [Paciente en consulta](https://unsplash.com/photos/a-man-getting-his-teeth-checked-by-a-dentist-7lBJaJpS3z4) |
| `instrumentos.jpg` | [Instrumental dental](https://unsplash.com/photos/a-pair-of-dental-instruments-sitting-on-top-of-a-bed-R8MoN4FV5q0) |

Créditos: Ozkan Guner, Filip Rankovic Grobgaard y Shedrack Salami, publicadas bajo la [licencia de Unsplash](https://unsplash.com/license).

---

## 👩‍💻 Autoría y propósito

Proyecto desarrollado por **Mariazambrano26** con fines educativos, para practicar el desarrollo de aplicaciones web con PHP, MySQL, AJAX y Bootstrap, siguiendo la estructura de la práctica del curso.

- **Licencia:** libre para uso académico y de aprendizaje.
