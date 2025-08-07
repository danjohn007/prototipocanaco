# Sistema de Afiliación - Cámara de Comercio de Querétaro

Sistema completo de autoafiliación para comerciantes y dashboard administrativo con gráficas, validaciones y control de usuarios.

## Características Principales

### Para Comerciantes (Público)
- **Formulario de autoafiliación** con información empresarial completa
- **Selección de membresía** (Básica, Intermedia, Premium, Corporativa)
- **Selección de sector** (Comercio, Industria, Turismo, Servicios)
- **Subida de productos estrella** (hasta 5 productos con imagen)
- **Confirmación automática** de solicitud enviada

### Para Administradores
- **Dashboard con gráficas** usando Chart.js
- **Sistema de roles** (Administrador, Validador, Analista)
- **Gestión de afiliaciones** con filtros y búsqueda
- **Validación de documentos/productos**
- **Seguimiento de estatus** (Pendiente, En Proceso, Validada, Rechazada)
- **Exportación de datos** a CSV
- **Registro de actividad** y cambios

## Tecnologías Utilizadas

- **PHP 8.x** (Puro, sin framework)
- **MySQL 5.7+**
- **HTML5 + CSS3 + JavaScript**
- **Bootstrap 5** para responsive design
- **Chart.js** para gráficas y análisis
- **Font Awesome** para iconos
- **MVC** arquitectura modular

## Estructura del Proyecto

```
prototipocanaco/
├── config/
│   ├── database.php          # Configuración de base de datos
│   └── schema.sql            # Esquema de base de datos
├── controllers/
│   ├── AfiliacionController.php
│   ├── AdminController.php
│   └── AuthController.php
├── models/
│   ├── Usuario.php
│   ├── Afiliacion.php
│   ├── Producto.php
│   ├── Membresia.php
│   └── Sector.php
├── views/
│   ├── afiliacion/
│   │   ├── formulario.php
│   │   └── confirmacion.php
│   ├── admin/
│   │   ├── login.php
│   │   ├── dashboard.php
│   │   ├── afiliaciones.php
│   │   └── detalle_afiliacion.php
│   └── partials/
│       ├── header.php
│       └── footer.php
├── public/
│   ├── index.php             # Punto de entrada
│   ├── css/
│   ├── js/
│   └── uploads/
├── routes/
│   └── web.php               # Sistema de enrutamiento
└── .htaccess                 # Configuración Apache
```

## Instalación

### 1. Configuración del Servidor

Asegúrate de tener:
- Apache 2.4+ con mod_rewrite habilitado
- PHP 8.0+ con extensiones PDO y PDO_MySQL
- MySQL 5.7+ o MariaDB 10.3+

### 2. Configuración de la Base de Datos

**Usando las credenciales proporcionadas:**

```sql
-- Base de datos: camaradecomercio_crm
-- Usuario: camaradecomercio_crm
-- Contraseña: Danjohn007
```

1. Ejecuta el archivo `config/schema.sql` para crear las tablas:

```bash
mysql -u camaradecomercio_crm -p camaradecomercio_crm < config/schema.sql
```

### 3. Configuración del Proyecto

1. Clona el repositorio en tu servidor web
2. Configura el DocumentRoot hacia la carpeta `public/`
3. Asegúrate de que la carpeta `public/uploads/` tenga permisos de escritura:

```bash
chmod 755 public/uploads/
chmod 755 public/uploads/productos/
```

4. Verifica la configuración en `config/database.php`

### 4. Configuración de Apache

El archivo `.htaccess` está configurado para:
- Redirigir todas las peticiones al directorio `public/`
- Habilitar URL amigables
- Configurar seguridad básica
- Habilitar compresión y cache

## Uso del Sistema

### Acceso Público (Afiliación)

1. Visita la URL base del proyecto
2. Completa el formulario de afiliación con:
   - Información personal y de contacto
   - Datos de la empresa
   - Selección de sector y membresía
   - Productos estrella (opcional)
3. Recibe confirmación de envío

### Acceso Administrativo

**URL:** `/admin/login`

**Credenciales por defecto:**

**Administrador:**
- Email: `admin@camaradecomercioqro.mx`
- Contraseña: `admin123`

**Validador:**
- Email: `validador@camaradecomercioqro.mx`
- Contraseña: `admin123`

### Funcionalidades del Dashboard

1. **Vista general** con estadísticas y gráficos
2. **Gestión de afiliaciones** con filtros por estatus y sector
3. **Validación de solicitudes** con cambio de estatus
4. **Exportación de datos** en formato CSV
5. **Visualización de productos** y documentos adjuntos

## API y Rutas

### Rutas Públicas
- `GET /` - Formulario de afiliación
- `POST /afiliacion` - Procesar solicitud
- `GET /afiliacion/confirmacion` - Página de confirmación

### Rutas Administrativas
- `GET /admin/login` - Formulario de login
- `POST /admin/login` - Procesar login
- `GET /admin/dashboard` - Dashboard principal
- `GET /admin/afiliaciones` - Lista de afiliaciones
- `GET /admin/afiliacion/{id}` - Detalle de afiliación
- `POST /admin/afiliacion/actualizar` - Actualizar estatus
- `GET /admin/exportar` - Exportar datos CSV
- `GET /admin/api/charts` - Datos para gráficas (JSON)

## Base de Datos

### Tablas Principales

- **usuarios** - Gestión de usuarios del sistema
- **afiliaciones** - Solicitudes de afiliación
- **productos** - Productos estrella de empresas
- **membresias** - Tipos de membresía disponibles
- **sectores** - Sectores empresariales
- **logs** - Registro de actividad del sistema

### Datos Iniciales

El sistema incluye datos iniciales:
- 4 sectores empresariales
- 4 tipos de membresía
- 2 usuarios administrativos

## Seguridad

- Contraseñas hasheadas con bcrypt
- Validación de entrada en formularios
- Protección contra inyección SQL usando PDO
- Restricción de acceso por roles
- Validación de tipos de archivo en uploads
- Headers de seguridad en Apache

## Mantenimiento

### Logs y Monitoreo
- Los logs de actividad se guardan automáticamente
- Revisar `/admin/dashboard` para estadísticas
- Exportar datos periódicamente

### Backup
```bash
# Backup de base de datos
mysqldump -u camaradecomercio_crm -p camaradecomercio_crm > backup.sql

# Backup de archivos subidos
tar -czf uploads_backup.tar.gz public/uploads/
```

## Personalización

### Agregar Nuevos Sectores o Membresías
Utiliza las tablas `sectores` y `membresias` para agregar nuevas opciones.

### Modificar Estilos
Edita el archivo `public/css/style.css` para personalizar la apariencia.

### Agregar Nuevos Campos
Modifica los modelos, controladores y vistas correspondientes.

## Soporte

Para soporte técnico o consultas, contacta al administrador del sistema.
