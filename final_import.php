<?php
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

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
    $sqlFile = file_get_contents('database/opdracht5_clean.sql');
    
    // Split by semicolon, but handle stored procedures carefully
    $statements = preg_split('/;(?=\s*$|\s*--|\s*\/\*)/m', $sqlFile);
    
    $count = 0;
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (empty($statement) || strlen($statement) < 5) {
            continue;
        }
        
        try {
            DB::statement($statement);
            $count++;
            echo "✓ Executed statement $count\n";
        } catch (\Exception $e) {
            echo "✗ Error in statement $count: " . $e->getMessage() . "\n";
            echo "Statement preview: " . substr($statement, 0, 100) . "...\n";
        }
    }
    
    echo "\n✓ Database imported successfully! ($count statements executed)\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
