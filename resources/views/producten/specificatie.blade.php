<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specificatie geleverde producten</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        header { background: #2c3e50; color: white; padding: 20px 0; margin-bottom: 30px; }
        header h1 { margin: 0 0 10px 0; }
        header a { color: white; text-decoration: none; margin-right: 20px; padding: 8px 12px; background: rgba(255,255,255,0.1); border-radius: 4px; }
        header a:hover { background: rgba(255,255,255,0.2); }
        
        .breadcrumb { margin-bottom: 20px; color: #555; font-size: 14px; }
        .breadcrumb a { color: #2c3e50; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb; }
        
        .detail-section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .detail-section h2 { color: #2c3e50; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        
        .product-info { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
        .info-row { }
        .info-label { font-weight: bold; color: #555; margin-bottom: 5px; }
        .info-value { color: #333; font-size: 15px; }
        
        .allergens { margin-top: 8px; font-size: 15px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #34495e; color: white; padding: 12px; text-align: left; font-weight: bold; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f9f9f9; }
        
        .back-link { display: inline-block; margin-bottom: 20px; padding: 8px 16px; background: #34495e; color: white; text-decoration: none; border-radius: 4px; }
        .back-link:hover { background: #2c3e50; }
        
        .no-deliveries { text-align: center; color: #888; padding: 30px; }

        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #2c3e50; }
        .pagination a:hover { background: #2c3e50; color: #fff; }
        .pagination .active { background: #2c3e50; color: #fff; border-color: #2c3e50; }
        .pagination .disabled { color: #ccc; cursor: not-allowed; }

        .results-meta { text-align: center; font-size: 12px; color: #888; margin-top: 10px; }
        
        footer { margin-top: 40px; padding: 20px; text-align: center; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Jamin Bedrijf</h1>
        </div>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}">Home</a> / <a href="{{ route('producten.index') }}">Overzicht geleverde producten</a> / Specificatie
        </div>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (isset($product))
            <!-- WIREFRAME 03: Product Specification -->
            <div class="detail-section">
                <h2>Specificatie geleverde producten</h2>
                <div class="product-info">
                    <div class="info-row">
                        <div class="info-label">Startdatum</div>
                        <div class="info-value">{{ $startDate }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Einddatum</div>
                        <div class="info-value">{{ $endDate }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Productnaam</div>
                        <div class="info-value">{{ $product->Naam }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Allergenen</div>
                        <div class="info-value allergens">
                            @if (count($allergens) > 0)
                                {{ collect($allergens)->pluck('Naam')->implode(', ') }}
                            @else
                                Geen
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Records -->
            <div class="detail-section">
                <h2>Leveringen</h2>

                @if ($deliveries && count($deliveries) > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Datum levering</th>
                                <th>Aantal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliveries as $delivery)
                                <tr>
                                    <td>
                                        @php
                                            $date = \DateTime::createFromFormat('Y-m-d', $delivery->DatumLevering);
                                            echo $date->format('d-m-Y');
                                        @endphp
                                    </td>
                                    <td>{{ $delivery->Aantal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($pagination['last_page'] > 1)
                        <div class="pagination">
                            @if ($pagination['current_page'] > 1)
                                <a href="{{ route('producten.specification', ['productId' => $product->Id, 'startDate' => $startDate, 'endDate' => $endDate, 'page' => 1]) }}">« Eerste</a>
                                <a href="{{ route('producten.specification', ['productId' => $product->Id, 'startDate' => $startDate, 'endDate' => $endDate, 'page' => $pagination['current_page'] - 1]) }}">‹ Vorige</a>
                            @else
                                <span class="disabled">« Eerste</span>
                                <span class="disabled">‹ Vorige</span>
                            @endif

                            @for ($i = 1; $i <= $pagination['last_page']; $i++)
                                @if ($i == $pagination['current_page'])
                                    <span class="active">{{ $i }}</span>
                                @else
                                    <a href="{{ route('producten.specification', ['productId' => $product->Id, 'startDate' => $startDate, 'endDate' => $endDate, 'page' => $i]) }}">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($pagination['current_page'] < $pagination['last_page'])
                                <a href="{{ route('producten.specification', ['productId' => $product->Id, 'startDate' => $startDate, 'endDate' => $endDate, 'page' => $pagination['current_page'] + 1]) }}">Volgende ›</a>
                                <a href="{{ route('producten.specification', ['productId' => $product->Id, 'startDate' => $startDate, 'endDate' => $endDate, 'page' => $pagination['last_page']]) }}">Laatste »</a>
                            @else
                                <span class="disabled">Volgende ›</span>
                                <span class="disabled">Laatste »</span>
                            @endif
                        </div>
                        <div class="results-meta">
                            Getoond {{ $pagination['from'] }} tot {{ $pagination['to'] }} van {{ $pagination['total'] }} resultaten
                        </div>
                    @endif
                @else
                    <div class="no-deliveries">
                        Geen leveringen gevonden in deze periode.
                    </div>
                @endif
            </div>

            <a href="{{ route('producten.index', ['startDate' => $startDate, 'endDate' => $endDate]) }}" class="back-link">← Terug naar Overzicht</a>
        @else
            <div class="error">
                <p>Product niet gevonden</p>
            </div>
            <a href="{{ route('producten.index') }}" class="back-link">← Terug naar Overzicht</a>
        @endif
    </div>

    <footer>
        Jamin Bedrijf
    </footer>
</body>
</html>
