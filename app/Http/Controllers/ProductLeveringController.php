<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductLeveringController extends Controller
{
    /**
     * Scenario 01 + Base View: Overzicht geleverde producten met datumfilter
     */
    public function index(Request $request)
    {
        $startDateInput = $request->input('startDate');
        $endDateInput = $request->input('endDate');
        $page = max(1, (int) $request->input('page', 1));
        
        $hasFilter = $startDateInput && $endDateInput;
        $hasResults = true;
        $products = collect();
        $totalResults = 0;
        $perPage = 4;

        // Convert dd-mm-yyyy to yyyy-mm-dd if filter is applied
        $startDate = '2000-01-01';
        $endDate = now()->toDateString();
        
        if ($hasFilter) {
            try {
                $dateStart = \DateTime::createFromFormat('d-m-Y', $startDateInput);
                $dateEnd = \DateTime::createFromFormat('d-m-Y', $endDateInput);

                // Also support yyyy-mm-dd input format
                if (!$dateStart || !$dateEnd) {
                    $dateStart = \DateTime::createFromFormat('Y-m-d', $startDateInput);
                    $dateEnd = \DateTime::createFromFormat('Y-m-d', $endDateInput);
                }
                
                if (!$dateStart || !$dateEnd) {
                    throw new \Exception('Invalid date format');
                }

                if ($dateStart > $dateEnd) {
                    throw new \Exception('Start date is after end date');
                }
                
                $startDate = $dateStart->format('Y-m-d');
                $endDate = $dateEnd->format('Y-m-d');
                
                // Scenario 01: Get products with deliveries in date range (sorted A-Z by Leverancier)
                $allProducts = DB::select(
                    'CALL GetProductsByDateRange(?, ?)',
                    [$startDate, $endDate]
                );
                
                $products = collect($allProducts);
                $products = $this->attachContactPersons($products);
                $totalResults = $products->count();
                $hasResults = $totalResults > 0;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors('Ongeldige datuminvoer. Gebruik dd-mm-yyyy of yyyy-mm-dd en controleer dat de startdatum niet na de einddatum ligt.');
            }
        } else {
            // Initial load: Get all products ever delivered (sorted A-Z by Leverancier)
            $allProducts = DB::select(
                'CALL GetProductsByDateRange(?, ?)',
                ['2000-01-01', now()->toDateString()]
            );
            
            $products = collect($allProducts);
            $products = $this->attachContactPersons($products);
            $totalResults = $products->count();
        }

        // Manual pagination (Laravel's paginate doesn't work well with stored procedures)
        $offset = ($page - 1) * $perPage;
        $paginatedProducts = $products->slice($offset, $perPage);
        
        $pagination = [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $totalResults,
            'last_page' => max(1, ceil($totalResults / $perPage)),
            'from' => $totalResults > 0 ? $offset + 1 : 0,
            'to' => min($offset + $perPage, $totalResults),
        ];

        return view('producten.overzicht', [
            'products' => $paginatedProducts,
            'pagination' => $pagination,
            'startDate' => $startDateInput ?: '',
            'endDate' => $endDateInput ?: '',
            'hasFilter' => $hasFilter,
            'hasResults' => $hasResults,
            'totalResults' => $totalResults,
        ]);
    }

    /**
     * Scenario 02: Specificatie van geleverde product (detail view)
     */
    public function specification(Request $request)
    {
        $productId = $request->input('productId');
        $startDateInput = $request->input('startDate');
        $endDateInput = $request->input('endDate');
        $page = $request->input('page', 1);

        if (!$productId || !$startDateInput || !$endDateInput) {
            return redirect()->route('producten.index')
                ->withErrors('Ongeldige parameters');
        }

        // Convert dd-mm-yyyy to yyyy-mm-dd
        try {
            $dateStart = \DateTime::createFromFormat('Y-m-d', $startDateInput);
            $dateEnd = \DateTime::createFromFormat('Y-m-d', $endDateInput);
            
            if (!$dateStart || !$dateEnd) {
                $dateStart = \DateTime::createFromFormat('d-m-Y', $startDateInput);
                $dateEnd = \DateTime::createFromFormat('d-m-Y', $endDateInput);
            }
            
            if (!$dateStart || !$dateEnd) {
                throw new \Exception('Invalid date format');
            }
            
            $startDate = $dateStart->format('Y-m-d');
            $endDate = $dateEnd->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors('Ongeldige datumformat');
        }

        // Get product info from database
        $product = DB::table('ProductPerLeverancier')
            ->select(
                'ProductPerLeverancier.ProductId as Id',
                'Product.Naam',
                'Product.Barcode',
                'Leverancier.Naam as LeverancierNaam'
            )
            ->join('Product', 'ProductPerLeverancier.ProductId', '=', 'Product.Id')
            ->join('Leverancier', 'ProductPerLeverancier.LeverancierId', '=', 'Leverancier.Id')
            ->where('ProductPerLeverancier.ProductId', $productId)
            ->where('Product.IsActief', 1)
            ->first();

        if (!$product) {
            return redirect()->route('producten.index')
                ->withErrors('Product niet gevonden');
        }

        // Get allergens using stored procedure
        $allergens = DB::select(
            'CALL GetAllergensForProduct(?)',
            [$productId]
        );

        // Get specialty info (deliveries in date range)
        $allDeliveries = DB::select(
            'CALL GetProductSpecification(?, ?, ?)',
            [$productId, $startDate, $endDate]
        );

        $deliveries = collect($allDeliveries);
        $totalResults = $deliveries->count();
        
        // Calculate totals
        $deliveryCount = $totalResults;
        $totalQuantity = $deliveries->sum(function ($delivery) {
            return $delivery->Aantal ?? 0;
        });
        
        $perPage = 4;
        $offset = ($page - 1) * $perPage;
        $paginatedDeliveries = $deliveries->slice($offset, $perPage);

        $pagination = [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $totalResults,
            'last_page' => max(1, ceil($totalResults / $perPage)),
            'from' => $totalResults > 0 ? $offset + 1 : 0,
            'to' => min($offset + $perPage, $totalResults),
        ];

        return view('producten.specificatie', [
            'product' => $product,
            'allergens' => $allergens,
            'deliveries' => $paginatedDeliveries,
            'pagination' => $pagination,
            'startDate' => $dateStart->format('d-m-Y'),
            'endDate' => $dateEnd->format('d-m-Y'),
            'deliveryCount' => $deliveryCount,
            'totalQuantity' => $totalQuantity,
        ]);
    }

    /**
     * Validation helper for date inputs
     */
    public function validateDateRange(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date_format:d-m-Y',
            'endDate' => 'required|date_format:d-m-Y|after:startDate',
        ], [
            'startDate.required' => 'Startdatum is verplicht',
            'startDate.date_format' => 'Startdatum moet format dd-mm-yyyy zijn',
            'endDate.required' => 'Einddatum is verplicht',
            'endDate.date_format' => 'Einddatum moet format dd-mm-yyyy zijn',
            'endDate.after' => 'Einddatum moet na startdatum liggen',
        ]);
    }

    private function attachContactPersons($products)
    {
        if ($products->isEmpty()) {
            return $products;
        }

        $leverancierNamen = $products->pluck('LeverancierNaam')->filter()->unique()->values();
        $contactMap = DB::table('Leverancier')
            ->whereIn('Naam', $leverancierNamen)
            ->pluck('ContactPersoon', 'Naam');

        return $products->map(function ($product) use ($contactMap) {
            $product->ContactPersoon = $contactMap[$product->LeverancierNaam] ?? '-';
            return $product;
        });
    }
}
