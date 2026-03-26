<?php
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Setup database connection
$db = new DB;
$db->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'opdracht5',
    'username' => 'root',
    'password' => '',
]);
$db->setAsGlobal();

try {
    $sqlFile = file_get_contents('database/opdracht5.sql');
    
    // Handle DELIMITER and split statements properly
    $statements = preg_split('/DELIMITER\s*[^;]+[;\n]/i', $sqlFile);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            // Split multi-statement blocks that used $$
            if (strpos($statement, '$$') !== false) {
                $parts = explode('$$', $statement);
                foreach ($parts as $part) {
                    $part = trim($part);
                    if (!empty($part)) {
                        DB::statement($part);
                    }
                }
            } else {
                DB::statement($statement);
            }
        }
    }
    
    echo "Database imported successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
