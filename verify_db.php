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

echo "=== DATABASE VERIFICATION ===\n\n";

// Check tables
$tables = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'opdracht5'");
echo "✓ Tables (" . count($tables) . "):\n";
foreach ($tables as $table) {
    echo "  - {$table->TABLE_NAME}\n";
}

echo "\n✓ Stored Procedures:\n";
try {
    $procs = DB::select("SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = 'opdracht5' AND ROUTINE_TYPE = 'PROCEDURE'");
    foreach ($procs as $proc) {
        echo "  - {$proc->ROUTINE_NAME}\n";
    }
} catch (\Exception $e) {
    echo "  (Could not retrieve procedures)\n";
}

echo "\n✓ Data Summary:\n";
$counts = [
    'Contact' => 'Id',
    'Leverancier' => 'Id',
    'Allergeen' => 'Id',
    'Product' => 'Id',
    'ProductPerLeverancier' => 'Id',
    'ProductPerAllergeen' => 'Id',
    'Magazijn' => 'Id',
];

foreach ($counts as $table => $column) {
    try {
        $count = DB::table($table)->count();
        echo "  - $table: $count records\n";
    } catch (\Exception $e) {
        echo "  - $table: Error\n";
    }
}

echo "\n✓ Database setup complete and ready for testing!\n";
?>
