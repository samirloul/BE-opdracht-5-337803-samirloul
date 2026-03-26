<?php
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;

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
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    // Insert Contacts
    DB::table('Contact')->insert([
        ['Straat' => 'Hoofdstraat', 'Huisnummer' => '1', 'Postcode' => '1000AA', 'Stad' => 'Amsterdam', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Straat' => 'Secundair Baan', 'Huisnummer' => '42', 'Postcode' => '2000BB', 'Stad' => 'Rotterdam', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Straat' => 'Zijweg', 'Huisnummer' => '99', 'Postcode' => '3000CC', 'Stad' => 'Den Haag', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
    ]);
    
    // Insert Allergens
    DB::table('Allergeen')->insert([
        ['Naam' => 'Pindas', 'Omschrijving' => 'Bevat pinda\'s', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Melk', 'Omschrijving' => 'Bevat melkproducten', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Gluten', 'Omschrijving' => 'Bevat gluten', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Noten', 'Omschrijving' => 'Bevat andere noten', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
    ]);
    
    // Insert Suppliers
    DB::table('Leverancier')->insert([
        ['Naam' => 'Jamin Bedrijf', 'ContactPersoon' => 'Jan de Vries', 'LeverancierNummer' => 'JAM001', 'Mobiel' => '0612345678', 'ContactId' => 1, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Global Foods', 'ContactPersoon' => 'Maria Garcia', 'LeverancierNummer' => 'GLF002', 'Mobiel' => '0687654321', 'ContactId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Fresh Products Ltd', 'ContactPersoon' => 'Robert Smith', 'LeverancierNummer' => 'FRP003', 'Mobiel' => '0699999999', 'ContactId' => 3, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
    ]);
    
    // Insert Products
    DB::table('Product')->insert([
        ['Naam' => 'Appel Gala', 'Barcode' => '8712345678901', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Chocolade Melk', 'Barcode' => '8712345678902', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Pindakaas', 'Barcode' => '8712345678903', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Brood Volkoren', 'Barcode' => '8712345678904', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Kaas Gouda', 'Barcode' => '8712345678905', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Yoghurt Natuur', 'Barcode' => '8712345678906', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
    ]);
    
    // Insert Product-Allergen relationships
    DB::table('ProductPerAllergeen')->insert([
        ['ProductId' => 2, 'AllergeenId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 3, 'AllergeenId' => 1, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 4, 'AllergeenId' => 3, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 5, 'AllergeenId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 6, 'AllergeenId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
    ]);
    
    // Insert Product Deliveries (for April 2023 test date range)
    $april2023 = Carbon::create(2023, 4, 8);
    DB::table('ProductPerLeverancier')->insert([
        ['ProductId' => 1, 'LeverancierId' => 1, 'DatumLevering' => $april2023->copy()->addDays(0)->toDateString(), 'Aantal' => 50, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 2, 'LeverancierId' => 1, 'DatumLevering' => $april2023->copy()->addDays(0)->toDateString(), 'Aantal' => 30, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 3, 'LeverancierId' => 2, 'DatumLevering' => $april2023->copy()->addDays(2)->toDateString(), 'Aantal' => 25, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 4, 'LeverancierId' => 2, 'DatumLevering' => $april2023->copy()->addDays(5)->toDateString(), 'Aantal' => 40, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 5, 'LeverancierId' => 3, 'DatumLevering' => $april2023->copy()->addDays(8)->toDateString(), 'Aantal' => 20, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 6, 'LeverancierId' => 1, 'DatumLevering' => $april2023->copy()->addDays(10)->toDateString(), 'Aantal' => 35, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['ProductId' => 1, 'LeverancierId' => 2, 'DatumLevering' => $april2023->copy()->addDays(12)->toDateString(), 'Aantal' => 45, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
    ]);
    
    // Insert Warehouses (optional)
    DB::table('Magazijn')->insert([
        ['Naam' => 'Magazijn Amsterdam', 'Adres' => 'Hartenstraat 1', 'Stad' => 'Amsterdam', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ['Naam' => 'Magazijn Rotterdam', 'Adres' => 'Scheepstimmermanslaan 5', 'Stad' => 'Rotterdam', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
    ]);
        // Insert Warehouse Stock (optional)
        DB::table('Magazijn')->insert([
            ['ProductId' => 1, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 100, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 2, 'VerpakkingsEenheid' => 0.5, 'AantalAanwezig' => 50, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 3, 'VerpakkingsEenheid' => 0.4, 'AantalAanwezig' => 80, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);

    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    
    echo "✓ Database seeded successfully!\n";
} catch (\Exception $e) {
    echo "✗ Error seeding database: " . $e->getMessage() . "\n";
}
?>
