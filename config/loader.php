<?php

class loader
    {
        public static function loadClass($className)
        {
            $classFile = self::findClassFile($className);
    
            if ($classFile !== false) {
                require_once $classFile;
            }
        }
    
        private static function findClassFile($className)
        {
            $directories = [
                __DIR__ . '/class/',  // Aktualny katalog
                __DIR__ . '/../class/',  // Katalog nadrzędny
            ];
    
            foreach ($directories as $directory) {
                $classFile = $directory . $className . '.class.php';
                if (file_exists($classFile)) {
                    return $classFile;
                }
            }
    
            return false;
        }
    }
    
    spl_autoload_register(['loader', 'loadClass']);
    
?>