<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class ProductLeveringTest extends TestCase
{
    /**
     * Scenario 01: manager ziet gefilterd overzicht met totaal aantallen.
     */
    public function test_scenario_01_filtered_overview_is_rendered_with_products(): void
    {
        DB::shouldReceive('select')
            ->once()
            ->with('CALL GetProductsByDateRange(?, ?)', ['2023-04-08', '2023-04-19'])
            ->andReturn([
                (object) [
                    'Id' => 1,
                    'Naam' => 'Mintnopjes',
                    'Barcode' => '8719587231278',
                    'LeverancierNaam' => 'Venco',
                    'TotalAantal' => 44,
                    'AantalLeveringen' => 2,
                ],
            ]);

        $builder = Mockery::mock();
        DB::shouldReceive('table')->once()->with('Leverancier')->andReturn($builder);
        $builder->shouldReceive('whereIn')->once()->with('Naam', Mockery::type('Illuminate\\Support\\Collection'))->andReturnSelf();
        $builder->shouldReceive('pluck')->once()->with('ContactPersoon', 'Naam')->andReturn(collect(['Venco' => 'Bert van Linge']));

        $response = $this->get('/producten?startDate=08-04-2023&endDate=19-04-2023');

        $response->assertOk();
        $response->assertSee('Mintnopjes');
        $response->assertSee('Venco');
        $response->assertSee('44');
        $response->assertSee('Bert van Linge');
    }

    /**
     * Scenario 03: manager krijgt melding wanneer periode geen leveringen heeft.
     */
    public function test_scenario_03_shows_no_deliveries_message_for_empty_range(): void
    {
        DB::shouldReceive('select')
            ->once()
            ->with('CALL GetProductsByDateRange(?, ?)', ['2024-05-07', '2025-05-14'])
            ->andReturn([]);

        $response = $this->get('/producten?startDate=07-05-2024&endDate=14-05-2025');

        $response->assertOk();
        $response->assertSee('Er zijn geen leveringen geweest van producten in deze periode');
    }
}
