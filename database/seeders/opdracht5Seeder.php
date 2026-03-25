<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class opdracht5Seeder extends Seeder
{
    public function run(): void
    {
        // Contact data
        DB::table('contacts')->insert([
            ['Straat' => 'Van Gilslaan', 'Huisnummer' => '34', 'Postcode' => '1045CB', 'Stad' => 'Hilvarenbeek', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Straat' => 'Den Dolderpad', 'Huisnummer' => '2', 'Postcode' => '1067RC', 'Stad' => 'Utrecht', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Straat' => 'Fredo Raalteweg', 'Huisnummer' => '257', 'Postcode' => '1236OP', 'Stad' => 'Nijmegen', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Straat' => 'Bertrand Russellhof', 'Huisnummer' => '21', 'Postcode' => '2034AP', 'Stad' => 'Den Haag', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Straat' => 'Leon van Bonstraat', 'Huisnummer' => '213', 'Postcode' => '145XC', 'Stad' => 'Lunteren', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Straat' => 'Bea van Lingenlaan', 'Huisnummer' => '234', 'Postcode' => '2197FG', 'Stad' => 'Sint Pancras', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);

        // Leverancier data
        DB::table('leveranciers')->insert([
            ['Naam' => 'Venco', 'ContactPersoon' => 'Bert van Linge', 'LeverancierNummer' => 'L1029384719', 'Mobiel' => '06-28493827', 'ContactId' => 1, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Astra Sweets', 'ContactPersoon' => 'Jasper del Monte', 'LeverancierNummer' => 'L1029284315', 'Mobiel' => '06-39398734', 'ContactId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Haribo', 'ContactPersoon' => 'Sven Stalman', 'LeverancierNummer' => 'L1029324748', 'Mobiel' => '06-24383291', 'ContactId' => 3, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Basset', 'ContactPersoon' => 'Joyce Stelterberg', 'LeverancierNummer' => 'L1023845773', 'Mobiel' => '06-48293823', 'ContactId' => 4, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'De Bron', 'ContactPersoon' => 'Remco Veenstra', 'LeverancierNummer' => 'L1023857736', 'Mobiel' => '06-34291234', 'ContactId' => 5, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Quality Street', 'ContactPersoon' => 'Johan Nooij', 'LeverancierNummer' => 'L1029234586', 'Mobiel' => '06-23458456', 'ContactId' => 6, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Hom Ken Food', 'ContactPersoon' => 'Hom Ken', 'LeverancierNummer' => 'L1029234599', 'Mobiel' => '06-23458477', 'ContactId' => null, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);

        // Allergeen data
        DB::table('allergeens')->insert([
            ['Naam' => 'Gluten', 'Omschrijving' => 'Dit product bevat gluten', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Gelatine', 'Omschrijving' => 'Dit product bevat gelatine', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'AZO-Kleurstof', 'Omschrijving' => 'Dit product bevat AZO-kleurstoffen', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Lactose', 'Omschrijving' => 'Dit product bevat lactose', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Soja', 'Omschrijving' => 'Dit product bevat soja', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);

        // Product data
        DB::table('products')->insert([
            ['Naam' => 'Mintnopjes', 'Barcode' => '8719587231278', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Schoolkrijt', 'Barcode' => '8719587326713', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Honingdrop', 'Barcode' => '8719587327836', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Zure Beren', 'Barcode' => '8719587321441', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Cola Flesjes', 'Barcode' => '8719587321237', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Turtles', 'Barcode' => '8719587322245', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Witte Muizen', 'Barcode' => '8719587328256', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Reuzen Slangen', 'Barcode' => '8719587325641', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Zoute Rijen', 'Barcode' => '8719587322739', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Winegums', 'Barcode' => '8719587327527', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Drop Munten', 'Barcode' => '8719587322345', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Kruis Drop', 'Barcode' => '8719587322265', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Zoute Ruitjes', 'Barcode' => '8719587323256', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['Naam' => 'Drop ninja\'s', 'Barcode' => '8719587323277', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);

        // ProductPerAllergeen data
        DB::table('product_per_allergeens')->insert([
            ['ProductId' => 1, 'AllergeenId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 1, 'AllergeenId' => 1, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 1, 'AllergeenId' => 3, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 3, 'AllergeenId' => 4, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 6, 'AllergeenId' => 5, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 9, 'AllergeenId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 9, 'AllergeenId' => 5, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 10, 'AllergeenId' => 2, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 12, 'AllergeenId' => 4, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 13, 'AllergeenId' => 1, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 13, 'AllergeenId' => 4, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 13, 'AllergeenId' => 5, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 14, 'AllergeenId' => 5, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);

        // ProductPerLeverancier data
        DB::table('product_per_leveranciers')->insert([
            ['LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2023-04-09', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2023-04-16', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2023-04-18', 'Aantal' => 21, 'DatumEerstVolgendeLevering' => '2023-04-25', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 1, 'ProductId' => 2, 'DatumLevering' => '2023-04-09', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2023-04-16', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 1, 'ProductId' => 3, 'DatumLevering' => '2023-04-10', 'Aantal' => 11, 'DatumEerstVolgendeLevering' => '2023-04-17', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2023-04-14', 'Aantal' => 16, 'DatumEerstVolgendeLevering' => '2023-04-21', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2023-04-21', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2023-04-28', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 2, 'ProductId' => 5, 'DatumLevering' => '2023-04-14', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => '2023-04-21', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 2, 'ProductId' => 6, 'DatumLevering' => '2023-04-14', 'Aantal' => 30, 'DatumEerstVolgendeLevering' => '2023-04-21', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2023-04-12', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2023-04-19', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2023-04-19', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2023-04-26', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 3, 'ProductId' => 8, 'DatumLevering' => '2023-04-10', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2023-04-17', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 3, 'ProductId' => 9, 'DatumLevering' => '2023-04-11', 'Aantal' => 1, 'DatumEerstVolgendeLevering' => '2023-04-18', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 4, 'ProductId' => 10, 'DatumLevering' => '2023-04-16', 'Aantal' => 24, 'DatumEerstVolgendeLevering' => '2023-04-30', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2023-04-10', 'Aantal' => 47, 'DatumEerstVolgendeLevering' => '2023-04-17', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2023-04-19', 'Aantal' => 60, 'DatumEerstVolgendeLevering' => '2023-04-26', 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 5, 'ProductId' => 12, 'DatumLevering' => '2023-04-11', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => null, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 5, 'ProductId' => 13, 'DatumLevering' => '2023-04-12', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => null, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['LeverancierId' => 7, 'ProductId' => 14, 'DatumLevering' => '2023-04-14', 'Aantal' => 20, 'DatumEerstVolgendeLevering' => null, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);

        // Magazijn data
        DB::table('magazijns')->insert([
            ['ProductId' => 1, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 453, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 2, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 400, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 3, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 1, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 4, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 800, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 5, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => 234, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 6, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 345, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 7, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 795, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 8, 'VerpakkingsEenheid' => 10, 'AantalAanwezig' => 233, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 9, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 123, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 10, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => null, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 11, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 367, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 12, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 467, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
            ['ProductId' => 13, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 20, 'IsActief' => 1, 'DatumAangemaakt' => now(), 'DatumGewijzigd' => now()],
        ]);
    }
}
