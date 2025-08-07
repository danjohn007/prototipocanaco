<?php
/**
 * Demo Data for Chamber of Commerce CRM System
 * This provides static data when database is not available
 */

class DemoData {
    
    public static function getSectores() {
        return [
            ['id' => 1, 'nombre' => 'Comercio', 'descripcion' => 'Empresas dedicadas al comercio y venta de productos'],
            ['id' => 2, 'nombre' => 'Industria', 'descripcion' => 'Empresas manufactureras e industriales'],
            ['id' => 3, 'nombre' => 'Turismo', 'descripcion' => 'Empresas del sector turístico y hotelero'],
            ['id' => 4, 'nombre' => 'Servicios', 'descripcion' => 'Empresas de servicios profesionales y técnicos']
        ];
    }
    
    public static function getMembresias() {
        return [
            [
                'id' => 1,
                'nombre' => 'Básica',
                'costo' => 1500.00,
                'beneficios' => 'Acceso a eventos básicos, directorio de empresas',
                'descripcion' => 'Membresía de entrada con beneficios esenciales'
            ],
            [
                'id' => 2,
                'nombre' => 'Intermedia',
                'costo' => 3000.00,
                'beneficios' => 'Todos los beneficios básicos + capacitaciones, networking',
                'descripcion' => 'Membresía intermedia con beneficios ampliados'
            ],
            [
                'id' => 3,
                'nombre' => 'Premium',
                'costo' => 5000.00,
                'beneficios' => 'Todos los beneficios + consultoría, promoción preferencial',
                'descripcion' => 'Membresía premium con beneficios completos'
            ],
            [
                'id' => 4,
                'nombre' => 'Corporativa',
                'costo' => 10000.00,
                'beneficios' => 'Todos los beneficios + servicios exclusivos, representación',
                'descripcion' => 'Membresía corporativa para grandes empresas'
            ]
        ];
    }
    
    public static function getAfiliaciones() {
        return [
            [
                'id' => 1,
                'empresa' => 'Restaurante El Buen Sabor',
                'contacto' => 'María González',
                'usuario_email' => 'maria@buensabor.com',
                'telefono' => '442-123-4567',
                'direccion' => 'Av. Constituyentes 123, Centro Histórico',
                'sector_nombre' => 'Comercio',
                'membresia_nombre' => 'Básica',
                'estatus' => 'validada',
                'fecha_solicitud' => '2024-01-15 10:30:00',
                'fecha_validacion' => '2024-01-16 14:20:00'
            ],
            [
                'id' => 2,
                'empresa' => 'Textiles Querétaro SA',
                'contacto' => 'Carlos Hernández',
                'usuario_email' => 'carlos@textiles.mx',
                'telefono' => '442-987-6543',
                'direccion' => 'Zona Industrial Benito Juárez, Lote 45',
                'sector_nombre' => 'Industria',
                'membresia_nombre' => 'Premium',
                'estatus' => 'pendiente',
                'fecha_solicitud' => '2024-01-20 09:15:00',
                'fecha_validacion' => null
            ],
            [
                'id' => 3,
                'empresa' => 'Hotel Colonial Plaza',
                'contacto' => 'Ana Martínez',
                'usuario_email' => 'ana@colonialplaza.com',
                'telefono' => '442-555-0123',
                'direccion' => 'Plaza de Armas 8, Centro Histórico',
                'sector_nombre' => 'Turismo',
                'membresia_nombre' => 'Intermedia',
                'estatus' => 'en_proceso',
                'fecha_solicitud' => '2024-01-18 16:45:00',
                'fecha_validacion' => null
            ],
            [
                'id' => 4,
                'empresa' => 'Consultores QRO',
                'contacto' => 'Roberto Silva',
                'usuario_email' => 'roberto@consultoresqro.mx',
                'telefono' => '442-777-8888',
                'direccion' => 'Av. Universidad 456, Col. Del Cerro',
                'sector_nombre' => 'Servicios',
                'membresia_nombre' => 'Corporativa',
                'estatus' => 'rechazada',
                'fecha_solicitud' => '2024-01-10 11:00:00',
                'fecha_validacion' => '2024-01-12 09:30:00'
            ]
        ];
    }
    
    public static function getStatistics() {
        return [
            'por_estatus' => [
                ['estatus' => 'pendiente', 'total' => 5],
                ['estatus' => 'en_proceso', 'total' => 3],
                ['estatus' => 'validada', 'total' => 12],
                ['estatus' => 'rechazada', 'total' => 2]
            ],
            'por_sector' => [
                ['nombre' => 'Comercio', 'total' => 8],
                ['nombre' => 'Industria', 'total' => 6],
                ['nombre' => 'Turismo', 'total' => 4],
                ['nombre' => 'Servicios', 'total' => 4]
            ],
            'por_membresia' => [
                ['nombre' => 'Básica', 'total' => 10],
                ['nombre' => 'Intermedia', 'total' => 6],
                ['nombre' => 'Premium', 'total' => 4],
                ['nombre' => 'Corporativa', 'total' => 2]
            ],
            'totales' => [
                'total_afiliaciones' => 22,
                'pendientes' => 5,
                'validadas' => 12,
                'rechazadas' => 2
            ]
        ];
    }
    
    public static function getAfiliacionById($id) {
        $afiliaciones = self::getAfiliaciones();
        foreach ($afiliaciones as $afiliacion) {
            if ($afiliacion['id'] == $id) {
                // Add demo products
                $afiliacion['productos'] = [
                    [
                        'id' => 1,
                        'nombre' => 'Producto Estrella 1',
                        'descripcion' => 'Descripción del producto destacado',
                        'imagen' => null
                    ],
                    [
                        'id' => 2,
                        'nombre' => 'Producto Estrella 2',
                        'descripcion' => 'Otro producto importante de la empresa',
                        'imagen' => null
                    ]
                ];
                return $afiliacion;
            }
        }
        return null;
    }
    
    public static function demoLogin($email, $password) {
        $users = [
            'admin@camaradecomercioqro.mx' => [
                'id' => 1,
                'nombre' => 'Administrador General',
                'email' => 'admin@camaradecomercioqro.mx',
                'tipo_usuario' => 'administrador'
            ],
            'validador@camaradecomercioqro.mx' => [
                'id' => 2,
                'nombre' => 'Validador Principal',
                'email' => 'validador@camaradecomercioqro.mx',
                'tipo_usuario' => 'validador'
            ]
        ];
        
        if (isset($users[$email]) && $password === 'admin123') {
            return $users[$email];
        }
        
        return false;
    }
}
?>