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

// Define stored procedures manually
$procedures = [
    'GetProductsByDateRange' => '
    CREATE PROCEDURE GetProductsByDateRange(
        IN p_start_date DATE,
        IN p_end_date DATE
    )
    BEGIN
        SELECT
            p.Id,
            p.Naam,
            p.Barcode,
            l.Naam AS LeverancierNaam,
            SUM(ppl.Aantal) AS TotalAantal,
            COUNT(DISTINCT ppl.DatumLevering) AS AantalLeveringen
        FROM Product p
        INNER JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
        INNER JOIN Leverancier l ON ppl.LeverancierId = l.Id
        WHERE ppl.DatumLevering BETWEEN p_start_date AND p_end_date
        AND p.IsActief = 1
        AND l.IsActief = 1
        GROUP BY p.Id, p.Naam, p.Barcode, l.Naam
        ORDER BY l.Naam ASC, p.Naam ASC;
    END',
    
    'GetProductSpecification' => '
    CREATE PROCEDURE GetProductSpecification(
        IN p_product_id INT,
        IN p_start_date DATE,
        IN p_end_date DATE
    )
    BEGIN
        SELECT
            ppl.DatumLevering,
            p.Naam AS ProductNaam,
            l.Naam AS LeverancierNaam,
            ppl.Aantal,
            GROUP_CONCAT(a.Naam SEPARATOR \', \') AS Allergen
        FROM ProductPerLeverancier ppl
        INNER JOIN Product p ON ppl.ProductId = p.Id
        INNER JOIN Leverancier l ON ppl.LeverancierId = l.Id
        LEFT JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
        LEFT JOIN Allergeen a ON ppa.AllergeenId = a.Id
        WHERE ppl.ProductId = p_product_id
        AND ppl.DatumLevering BETWEEN p_start_date AND p_end_date
        AND p.IsActief = 1
        AND l.IsActief = 1
        GROUP BY ppl.DatumLevering, p.Naam, l.Naam, ppl.Aantal
        ORDER BY ppl.DatumLevering DESC;
    END',
    
    'GetAllergensForProduct' => '
    CREATE PROCEDURE GetAllergensForProduct(IN p_product_id INT)
    BEGIN
        SELECT
            a.Id,
            a.Naam,
            a.Omschrijving
        FROM Allergeen a
        INNER JOIN ProductPerAllergeen ppa ON a.Id = ppa.AllergeenId
        WHERE ppa.ProductId = p_product_id
        AND a.IsActief = 1
        AND ppa.IsActief = 1;
    END',
    
    'GetProductsWithoutLeveringen' => '
    CREATE PROCEDURE GetProductsWithoutLeveringen(
        IN p_start_date DATE,
        IN p_end_date DATE
    )
    BEGIN
        SELECT COUNT(*) AS HasResults
        FROM Product p
        INNER JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
        WHERE ppl.DatumLevering BETWEEN p_start_date AND p_end_date
        AND p.IsActief = 1;
    END'
];

foreach ($procedures as $name => $definition) {
    try {
        // Drop if exists
        DB::statement("DROP PROCEDURE IF EXISTS $name");
        // Create procedure
        DB::unprepared($definition);
        echo "✓ Created procedure: $name\n";
    } catch (\Exception $e) {
        echo "✗ Error creating $name: " . $e->getMessage() . "\n";
    }
}

echo "\n✓ All stored procedures created!\n";
?>
