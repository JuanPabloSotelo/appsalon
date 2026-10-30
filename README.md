# AppSalon — Sistema de Gestión de Citas

Aplicación web full-stack para la gestión de un salón de belleza, desarrollada con **Laravel, MySQL y Apache (XAMPP)**.
Este repositorio corresponde a la **Entrega Intermedia (Semana 11)** del Proyecto Final.

- **Universidad:** Universidad Santiago de Cali
- **Asignatura:** [Nombre de la asignatura]
- **Autor(es):** Juan Pablo Sotelo — [agregar integrantes, si aplica]

---

## Funcionalidades implementadas

### Autenticación y seguridad
- Registro de clientes con validación en el servidor (Form Request `RegisterRequest`).
- Confirmación de cuenta mediante token de un solo uso enviado por correo.
- Inicio y cierre de sesión (login/logout) con regeneración del ID de sesión.
- Contraseñas cifradas con **bcrypt** (`Hash::make`).
- Protección **CSRF** en todos los formularios (`@csrf`).
- Protección **XSS**: toda salida en Blade se escapa con `{{ }}` (equivalente a `htmlspecialchars`).
- Límite de 5 intentos de inicio de sesión por minuto (protección contra fuerza bruta).
- Los campos `admin` y `confirmado` están protegidos contra asignación masiva.

### Roles de usuario
- Dos roles: **cliente** y **administrador** (columna `admin`).
- `AdminMiddleware` restringe el panel de administración; un cliente que intenta entrar recibe un error 403.

### Gestión de servicios
- Catálogo público de servicios activos, con precio y duración.
- CRUD completo de servicios para administradores (crear, listar, editar, eliminar).
- Validación de datos (Form Request `ServiceRequest`), incluido el nombre único.
- Búsqueda por nombre y paginación.
- Activar/desactivar servicios. Un servicio que ya pertenece a una cita no se elimina, sino que se desactiva para conservar el historial.

### Interfaz y manejo de errores
- Diseño responsive con Bootstrap 5 (menú adaptable a celular).
- Mensajes de estado (éxito, advertencia, error) y errores de validación por campo.
- Páginas de error personalizadas: 403, 404, 419, 429 y 500.
- Registro de errores en `storage/logs/laravel.log`.

---

## Tecnologías utilizadas

| Tecnología | Uso |
|---|---|
| PHP 8.2+ | Lenguaje del servidor |
| Laravel 12 | Framework MVC (Eloquent, Blade, Validation, Auth) |
| MySQL / MariaDB (XAMPP) | Base de datos |
| Apache (XAMPP) | Servidor web |
| Bootstrap 5.3 + Bootstrap Icons | Interfaz responsive (vía CDN) |
| Composer | Gestor de dependencias de PHP |
| Git / GitHub | Control de versiones |

---

## Requisitos previos

- XAMPP con PHP 8.2 o superior (Apache y MySQL encendidos).
- Composer.
- Git.
- Extensiones de PHP habilitadas en `php.ini`: `zip`, `fileinfo`, `intl`, `pdo_mysql`.

---

## Instalación

1. **Clonar el repositorio** dentro de `C:\xampp\htdocs`:
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/JuanPabloSotelo/appsalon.git
   cd appsalon
   ```

2. **Instalar las dependencias:**
   ```bash
   composer install
   ```

3. **Crear el archivo de configuración** a partir del ejemplo y generar la clave de la aplicación:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Crear la base de datos** en phpMyAdmin (`http://localhost/phpmyadmin`):
   - Nombre: `appsalon_mvc_php`
   - Cotejamiento: `utf8mb4_unicode_ci`

   Si tu usuario de MySQL tiene contraseña, escríbela en `DB_PASSWORD` dentro de `.env`.

5. **Crear las tablas y cargar los datos de prueba:**
   ```bash
   php artisan migrate --seed
   ```
   *Alternativa sin Artisan:* importar en phpMyAdmin el script `database/appsalon_mvc_php.sql`.

6. **Abrir el sistema** en el navegador:
   ```
   http://localhost/appsalon/public
   ```
   Si la carpeta del proyecto tiene otro nombre, ajusta `APP_URL` en `.env`.

---

## Usuarios de prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | admin@appsalon.com | admin123 |
| Cliente | cliente@appsalon.com | cliente123 |

Ambas cuentas ya están confirmadas. Los datos de prueba incluyen además **9 servicios** y **1 cita** de ejemplo con dos servicios.

### Confirmar una cuenta nueva (entorno local)
En el entorno local el correo se configura con `MAIL_MAILER=log`, así que los correos no se envían por internet: se escriben al final de `storage/logs/laravel.log`. Después de registrarte, copia de ese archivo el enlace `http://localhost/appsalon/public/confirmar/...` y ábrelo en el navegador.

---

## Base de datos

Script SQL completo: [`database/appsalon_mvc_php.sql`](database/appsalon_mvc_php.sql)

| Tabla | Campos principales | Relaciones |
|---|---|---|
| `usuarios` | id, nombre, apellido, email, password, telefono, admin, confirmado, token | — |
| `servicios` | id, nombre, precio, descripcion, duracion, activo | — |
| `citas` | id, fecha, hora, usuarioId, total, estado | `usuarioId` → `usuarios.id` (ON DELETE SET NULL) |
| `citasServicios` | id, citaId, servicioId | `citaId` → `citas.id` (CASCADE), `servicioId` → `servicios.id` (CASCADE) |

**Ajustes respecto al script base del enunciado** (los nombres de las columnas se mantienen):
- `servicios.precio` y `citas.total` usan `DECIMAL(10,2)` en lugar de `DECIMAL(5,2)` / `DECIMAL(6,2)`, porque los precios en pesos colombianos (por ejemplo, 35.000) superan el máximo de 999,99.
- `usuarios.email` usa `VARCHAR(100)` en lugar de `VARCHAR(30)`, porque muchos correos reales superan los 30 caracteres.
- Las llaves primarias usan `BIGINT UNSIGNED`, la convención de Laravel (`$table->id()`).

Además están las tablas internas de Laravel: `migrations`, `password_reset_tokens`, `sessions`, `cache` y `jobs`.

---

## Rutas principales

| Método | URL | Descripción | Acceso |
|---|---|---|---|
| GET | `/` | Página de inicio | Público |
| GET | `/servicios` | Catálogo de servicios | Público |
| GET / POST | `/registro` | Registro de cliente | Visitante |
| GET / POST | `/login` | Inicio de sesión | Visitante |
| GET | `/confirmar/{token}` | Confirmación de cuenta | Visitante |
| POST | `/logout` | Cierre de sesión | Autenticado |
| GET | `/admin/servicios` | Listado de servicios | Administrador |
| GET / POST | `/admin/servicios/create`, `/admin/servicios` | Crear servicio | Administrador |
| GET / PUT | `/admin/servicios/{id}/edit`, `/admin/servicios/{id}` | Editar servicio | Administrador |
| DELETE | `/admin/servicios/{id}` | Eliminar servicio | Administrador |

---

## Estructura del proyecto (archivos propios)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php       # Registro, confirmación, login, logout
│   │   ├── HomeController.php       # Página de inicio
│   │   └── ServiceController.php    # Catálogo público y CRUD de servicios
│   ├── Middleware/
│   │   └── AdminMiddleware.php      # Restringe rutas a administradores
│   └── Requests/
│       ├── LoginRequest.php
│       ├── RegisterRequest.php
│       └── ServiceRequest.php
├── Models/
│   ├── User.php                     # Tabla usuarios
│   ├── Service.php                  # Tabla servicios
│   ├── Appointment.php              # Tabla citas
│   └── AppointmentService.php       # Tabla citasServicios
bootstrap/app.php                    # Registro del alias de middleware 'admin'
database/
├── migrations/                      # Estructura de las tablas
├── seeders/                         # Datos de prueba
└── appsalon_mvc_php.sql             # Script SQL completo
public/css/app.css                   # Estilos propios
resources/views/
├── layouts/app.blade.php            # Plantilla principal (menú y pie de página)
├── partials/alerts.blade.php        # Mensajes de estado
├── home.blade.php
├── auth/                            # login, register
├── services/                        # Catálogo público
├── admin/services/                  # index, create, edit, _form
└── errors/                          # 403, 404, 419, 429, 500
routes/web.php                       # Rutas de la aplicación
```

### Arquitectura (MVC)
- **Modelo:** clases Eloquent en `app/Models` con sus relaciones (`hasMany`, `belongsTo`, `belongsToMany`).
- **Vista:** plantillas Blade en `resources/views`, que heredan de un layout común.
- **Controlador:** `app/Http/Controllers` coordina la lógica. La validación se delega a los Form Requests y el control de acceso, a los middlewares `auth` y `admin`.
- **Acceso a datos:** Eloquent y el Query Builder usan *prepared statements*, lo que protege contra inyección SQL.

---

## Próximas funcionalidades (Entrega Final)
- Reserva de citas con calendario y validación de disponibilidad.
- Dashboard de administración con estadísticas.
- API REST con autenticación por token.
- Reportes y exportación a PDF/Excel.
