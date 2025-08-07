# Sistema de Afiliación - Cámara de Comercio de Querétaro

Sistema completo de autoafiliación para comerciantes y dashboard administrativo con gráficas, validaciones y control de usuarios.

## 🚀 Inicio Rápido

### 1. Acceso al Sistema

**URL del Sistema:** Accede a la URL base donde esté instalado el sistema (ejemplo: `http://localhost:8000` para desarrollo)

**Página Principal:** Formulario de afiliación público
- Los usuarios pueden completar el formulario de afiliación
- Seleccionar sector empresarial y tipo de membresía
- Subir productos estrella (opcional)
- Recibir confirmación automática

### 2. Acceso Administrativo

**URL de Administración:** `[URL_BASE]/admin/login`

**Credenciales por defecto:**

**👨‍💼 Administrador:**
- Email: `admin@camaradecomercioqro.mx`
- Contraseña: `admin123`

**🔍 Validador:**
- Email: `validador@camaradecomercioqro.mx`
- Contraseña: `admin123`

### 3. Funcionalidades del Dashboard Administrativo

Una vez autenticado, tendrás acceso a:
- 📊 Dashboard con estadísticas y gráficos en tiempo real
- 📋 Gestión completa de afiliaciones con filtros
- ✅ Validación y cambio de estatus de solicitudes
- 📥 Exportación de datos en formato CSV
- 👥 Gestión de usuarios del sistema

## 📋 Características Principales

### Para Comerciantes (Público)
- **✨ Formulario de autoafiliación** con información empresarial completa
- **💳 Selección de membresía** (Básica, Intermedia, Premium, Corporativa)
- **🏢 Selección de sector** (Comercio, Industria, Turismo, Servicios)
- **📸 Subida de productos estrella** (hasta 5 productos con imagen)
- **✅ Confirmación automática** de solicitud enviada

### Para Administradores
- **📊 Dashboard con gráficas** usando Chart.js
- **👤 Sistema de roles** (Administrador, Validador, Analista)
- **📝 Gestión de afiliaciones** con filtros y búsqueda
- **✅ Validación de documentos/productos**
- **📈 Seguimiento de estatus** (Pendiente, En Proceso, Validada, Rechazada)
- **💾 Exportación de datos** a CSV
- **📋 Registro de actividad** y cambios

## 🛠️ Tecnologías Utilizadas

- **PHP 8.x** (Puro, sin framework)
- **MySQL 5.7+** con fallback automático a **SQLite**
- **HTML5 + CSS3 + JavaScript**
- **Bootstrap 5** para responsive design
- **Chart.js** para gráficas y análisis
- **Font Awesome** para iconos
- **MVC** arquitectura modular

## 📁 Estructura del Proyecto

```
prototipocanaco/
├── config/
│   ├── database.php          # Configuración MySQL con fallback SQLite
│   ├── database_sqlite.php   # Base de datos SQLite automática
│   ├── config.php           # Configuración general y URLs
│   └── schema.sql           # Esquema MySQL (opcional)
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

## ⚙️ Instalación y Configuración

### Opción 1: Instalación Rápida (Recomendada)

El sistema funciona automáticamente con SQLite sin configuración adicional:

1. **Descargar y extraer** el proyecto en tu servidor web
2. **Configurar Apache/Nginx** para apuntar a la carpeta `public/`
3. **Asegurar permisos** de escritura en `public/uploads/`
4. **¡Listo!** El sistema creará automáticamente la base de datos SQLite

```bash
chmod 755 public/uploads/
chmod 755 public/uploads/productos/
```

### Opción 2: Configuración con MySQL

Si prefieres usar MySQL, configura las credenciales en `config/database.php`:

```php
private $host = 'localhost';
private $db_name = 'camaradecomercio_crm';
private $username = 'camaradecomercio_crm';
private $password = 'Danjohn007';
```

Luego ejecuta el esquema:
```bash
mysql -u usuario -p base_datos < config/schema.sql
```

### Requisitos del Servidor

- **Apache 2.4+** con mod_rewrite habilitado
- **PHP 8.0+** con extensiones PDO y PDO_SQLite
- **MySQL 5.7+** (opcional, usa SQLite por defecto)

## 🌐 API y Rutas

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

## 💾 Base de Datos

### Modo Automático (SQLite)
- Se crea automáticamente al primer acceso
- Incluye datos iniciales: sectores, membresías, usuarios admin
- Ubicación: `config/database.sqlite`
- No requiere configuración adicional

### Tablas Principales
- **usuarios** - Gestión de usuarios del sistema
- **afiliaciones** - Solicitudes de afiliación
- **productos** - Productos estrella de empresas
- **membresias** - Tipos de membresía disponibles
- **sectores** - Sectores empresariales
- **logs** - Registro de actividad del sistema

### Datos Iniciales Incluidos
- ✅ 4 sectores empresariales
- ✅ 4 tipos de membresía
- ✅ 2 usuarios administrativos

## 🔒 Seguridad

- ✅ Contraseñas hasheadas con bcrypt
- ✅ Validación de entrada en formularios
- ✅ Protección contra inyección SQL usando PDO
- ✅ Restricción de acceso por roles
- ✅ Validación de tipos de archivo en uploads
- ✅ Headers de seguridad en Apache
- ✅ Gestión automática de URLs y redirecciones

## 🛠️ Mantenimiento

### Logs y Monitoreo
- Los logs de actividad se guardan automáticamente
- Revisar `/admin/dashboard` para estadísticas
- Exportar datos periódicamente

### Backup
```bash
# Backup de base de datos SQLite
cp config/database.sqlite backup_$(date +%Y%m%d).sqlite

# Backup de archivos subidos
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz public/uploads/
```

### Backup MySQL (si se usa)
```bash
mysqldump -u camaradecomercio_crm -p camaradecomercio_crm > backup.sql
```

## 🎨 Personalización

### Agregar Nuevos Sectores o Membresías
- **Modo SQLite:** Utiliza el panel administrativo o modifica la base de datos directamente
- **Modo MySQL:** Utiliza las tablas `sectores` y `membresias`

### Modificar Estilos
Edita el archivo `public/css/style.css` para personalizar la apariencia.

### Agregar Nuevos Campos
1. Modifica las tablas en la base de datos
2. Actualiza los modelos correspondientes
3. Actualiza los controladores y vistas

## 🚀 Desarrollo

### Servidor de Desarrollo
```bash
cd prototipocanaco
php -S localhost:8000 -t public/
```

### Estructura de URLs
El sistema maneja automáticamente las URLs según el entorno:
- Desarrollo: `http://localhost:8000/`
- Producción: `http://tu-dominio.com/`

## ❓ Solución de Problemas

### El formulario no muestra sectores o membresías
- ✅ **Solucionado:** El sistema usa datos demo automáticamente si hay problemas de conectividad

### Las redirecciones no funcionan
- ✅ **Solucionado:** Sistema de URLs dinámico que se adapta automáticamente

### Error de permisos en uploads
```bash
chmod 755 public/uploads/
chmod 755 public/uploads/productos/
```

### Base de datos no conecta
- ✅ **Solucionado:** Fallback automático a SQLite sin configuración

## 📞 Soporte

Para soporte técnico o consultas sobre el sistema, contacta al administrador del sistema o revisa los logs en el dashboard administrativo.

---

**Versión:** 1.0.0  
**Última actualización:** Agosto 2025  
**Desarrollado para:** Cámara de Comercio de Querétaro