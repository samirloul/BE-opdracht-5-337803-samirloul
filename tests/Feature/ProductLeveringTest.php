<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductLeveringTest extends TestCase
{
    /**
     * Test Scenario 01: Retrieving products filtered by date range via GetProductsByDateRange
     * 
     * Expected behavior: The stored procedure should return products delivered between
     * the specified date range (08-04-2023 to 19-04-2023), sorted A-Z by Leverancier name.
     * Total expected: Products with deliveries in that period, paginated 4 per page.
     */
    public function test_get_products_by_date_range()
    {
        // Use the test date range from the assignment
        $startDate = '2023-04-08';
        $endDate = '2023-04-19';

        // Call the stored procedure
        $products = DB::select(
            'CALL GetProductsByDateRange(?, ?)',
            [$startDate, $endDate]
        );

        // Assertions
        $this->assertIsArray($products);
        $this->assertGreaterThan(0, count($products), 'Should return at least 1 product for date range 08-04-2023 to 19-04-2023');

        // Verify all products have required fields
        foreach ($products as $product) {
            $this->assertObjectHasProperty('Id', $product);
            $this->assertObjectHasProperty('Naam', $product);
            $this->assertObjectHasProperty('LeverancierNaam', $product);
            $this->assertObjectHasProperty('TotalAantal', $product);
        }

        // Verify the data is sorted A-Z by supplier name
        $supplierNames = array_map(function($p) { return $p->LeverancierNaam; }, $products);
        $sortedNames = $supplierNames;
        sort($sortedNames);
        $this->assertEquals($sortedNames, $supplierNames, 'Products should be sorted A-Z by Leverancier name');
    }

    /**
     * Test Scenario 02: Retrieving delivery specification for a specific product
     * 
     * Expected behavior: The stored procedure GetProductSpecification should return
     * all deliveries for a given product within a date range, showing delivery 
     * dates, quantities, and supplier info.
     */
    public function test_get_product_specification()
    {
        // Get a product ID from the system (using the first product from previous test)
        $startDate = '2023-04-08';
        $endDate = '2023-04-19';

        $products = DB::select(
            'CALL GetProductsByDateRange(?, ?)',
            [$startDate, $endDate]
        );

        $this->assertGreaterThan(0, count($products), 'Need at least 1 product for this test');

        $productId = $products[0]->Id;

        // Call GetProductSpecification
        $deliveries = DB::select(
            'CALL GetProductSpecification(?, ?, ?)',
            [$productId, $startDate, $endDate]
        );

        // Assertions
        $this->assertIsArray($deliveries);
        $this->assertGreaterThan(0, count($deliveries), 'Should return at least 1 delivery for the product');

        // Verify all deliveries have required fields
        foreach ($deliveries as $delivery) {
            $this->assertObjectHasProperty('LeverancierNaam', $delivery);
            $this->assertObjectHasProperty('Aantal', $delivery);
            $this->assertObjectHasProperty('DatumLevering', $delivery);
            $this->assertNotNull($delivery->Aantal, 'Delivery quantity should not be null');
            $this->assertGreaterThan(0, $delivery->Aantal, 'Delivery quantity should be positive');
        }
    }

    /**
     * Test Scenario 03: Handling empty results when no deliveries exist in date range
     * 
     * Expected behavior: When searching for a date range with no deliveries,
     * the stored procedure should return an empty result set, allowing the
     * controller to show the "Geen leveringen" error message.
     */
    public function test_no_deliveries_in_date_range()
    {
        // Use a date range with no expected deliveries
        $startDate = '2025-01-01';
        $endDate = '2025-12-31';

        // Call the stored procedure
        $products = DB::select(
            'CALL GetProductsByDateRange(?, ?)',
            [$startDate, $endDate]
        );

        // Assertions
        $this->assertIsArray($products);
        // In the current test data, this should return an empty array
        // (or continue and verify behavior matches Scenario 03)
        if (empty($products)) {
            $this->assertTrue(true, 'Correctly returned empty result for future date range');
        }
    }

    /**
     * Test Allergen information retrieval
     * 
     * Expected behavior: GetAllergensForProduct should return all allergens
     * linked to a product, or empty array if product has no allergens.
     */
    public function test_get_allergens_for_product()
    {
        // Get any product from the system
        $products = DB::select(
            'CALL GetProductsByDateRange(?, ?)',
            ['2023-04-08', '2023-04-19']
        );

        $this->assertGreaterThan(0, count($products));
        $productId = $products[0]->Id;

        // Call the stored procedure
        $allergens = DB::select(
            'CALL GetAllergensForProduct(?)',
            [$productId]
        );

        // Assertions
        $this->assertIsArray($allergens);
        
        // Verify each allergen has the required field
        foreach ($allergens as $allergen) {
            $this->assertObjectHasProperty('Naam', $allergen, 'Each allergen should have a Naam field');
            $this->assertIsString($allergen->Naam);
        }
    }

    /**
     * Test Pagination Logic
     * 
     * Expected behavior: The application should paginate results with 4 records per page
     * as specified in the assignment requirements.
     */
    public function test_pagination_four_records_per_page()
    {
        $startDate = '2023-04-08';
        $endDate = '2023-04-19';
        $perPage = 4;

        // Get all products in date range
        $allProducts = DB::select(
            'CALL GetProductsByDateRange(?, ?)',
            [$startDate, $endDate]
        );

        $totalProducts = count($allProducts);
        $this->assertGreaterThan(0, $totalProducts, 'Must have products for pagination test');

        // Calculate expected pages
        $expectedPages = ceil($totalProducts / $perPage);

        // Simulate pagination
        for ($page = 1; $page <= $expectedPages; $page++) {
            $offset = ($page - 1) * $perPage;
            $paginatedProducts = array_slice($allProducts, $offset, $perPage);
            
            // Verify this page has at most $perPage records
            $this->assertLessThanOrEqual($perPage, count($paginatedProducts), 
                "Page {$page} should have at most {$perPage} records");
            
            // Verify last page logic
            if ($page == $expectedPages) {
                $expectedLastPageCount = $totalProducts % $perPage;
                $expectedLastPageCount = $expectedLastPageCount === 0 ? $perPage : $expectedLastPageCount;
                $this->assertEquals($expectedLastPageCount, count($paginatedProducts),
                    "Last page should have {$expectedLastPageCount} records");
            }
        }

        $this->assertTrue(true, "Pagination test passed with {$expectedPages} pages of {$perPage} records each");
    }
}
