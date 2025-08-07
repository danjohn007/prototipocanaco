<?php
/**
 * Application Configuration
 * Chamber of Commerce CRM System
 */

class Config {
    /**
     * Get the base URL for the application
     */
    public static function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
        
        // Remove index.php and public/ from the path
        $base_path = str_replace(['/public/index.php', '/index.php'], '', $script_name);
        
        return $protocol . $host . $base_path;
    }

    /**
     * Get a full URL for a given path
     */
    public static function url($path = '') {
        $base_url = self::getBaseUrl();
        $path = ltrim($path, '/');
        return $base_url . '/' . $path;
    }

    /**
     * Redirect to a given path
     */
    public static function redirect($path = '') {
        $url = self::url($path);
        header("Location: $url");
        exit();
    }

    /**
     * Get current URL path
     */
    public static function getCurrentPath() {
        $request_uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($request_uri, PHP_URL_PATH);
        
        // Remove base path if it exists
        $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
        $base_path = str_replace(['/public/index.php', '/index.php'], '', $script_name);
        
        if ($base_path && strpos($path, $base_path) === 0) {
            $path = substr($path, strlen($base_path));
        }
        
        return $path ?: '/';
    }

    /**
     * Check if current environment is development
     */
    public static function isDevelopment() {
        return isset($_SERVER['SERVER_NAME']) && 
               ($_SERVER['SERVER_NAME'] === 'localhost' || 
                strpos($_SERVER['SERVER_NAME'], '127.0.0.1') !== false ||
                strpos($_SERVER['SERVER_NAME'], '.test') !== false ||
                strpos($_SERVER['SERVER_NAME'], '.local') !== false);
    }

    /**
     * Application settings
     */
    public static function get($key, $default = null) {
        $config = [
            'app_name' => 'Cámara de Comercio de Querétaro',
            'app_description' => 'Sistema de Afiliación y Gestión',
            'version' => '1.0.0',
            'timezone' => 'America/Mexico_City',
            'upload_max_size' => 5 * 1024 * 1024, // 5MB
            'allowed_image_types' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'],
        ];

        return $config[$key] ?? $default;
    }
}
?>