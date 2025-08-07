<?php
/**
 * Entry Point for Chamber of Commerce CRM System
 * Cámara de Comercio de Querétaro
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('America/Mexico_City');

// Include the router
require_once __DIR__ . '/../routes/web.php';
?>