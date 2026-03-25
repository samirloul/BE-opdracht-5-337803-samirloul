<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specificatie Product - Jamin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        header { background: #2c3e50; color: white; padding: 20px 0; margin-bottom: 30px; }
        header h1 { margin: 0 0 10px 0; }
        header a { color: white; text-decoration: none; margin-right: 20px; padding: 8px 12px; background: rgba(255,255,255,0.1); border-radius: 4px; }
        header a:hover { background: rgba(255,255,255,0.2); }
        
        .breadcrumb { margin-bottom: 20px; color: #888; font-size: 13px; }
        .breadcrumb a { color: #27ae60; text-decoration: none; }
        
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb; }
        
        .detail-section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .detail-section h2 { color: #2c3e50; margin-bottom: 15px; border-bottom: 2px solid #27ae60; padding-bottom: 10px; }
        
        .product-info { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
        .info-row { }
        .info-label { font-weight: bold; color: #555; margin-bottom: 5px; }
        .info-value { color: #333; font-size: 15px; }
        
        .allergens { background: #fff9e6; padding: 15px; border-radius: 4px; margin: 15px 0; border-left: 4px solid #f39c12; }
        .allergens h4 { color: #e67e22; margin-bottom: 10px; }
        .allergen-list { display: flex; gap: 10px; flex-wrap: wrap; }
        .allergen-badge { display: inline-block; background: #f39c12; color: white; padding: 5px 12px; border-radius: 20px; font-size: 13px; }
        .no-allergens { color: #27ae60; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #34495e; color: white; padding: 12px; text-align: left; font-weight: bold; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f9f9f9; }
        
        .back-link { display: inline-block; margin-bottom: 20px; padding: 8px 16px; background: #34495e; color: white; text-decoration: none; border-radius: 4px; }
        .back-link:hover { background: #2c3e50; }
        
        .no-deliveries { text-align: center; color: #888; padding: 30px; }
        
        footer { margin-top: 40px; padding: 20px; text-align: center; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Jamin Bedrijf</h1>
            <a href="{{ route('producten.index') }}">← Terug naar Overzicht</a>
        </div>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="/">Home</a> / <a href="{{ route('producten.index') }}">Overzicht</a> / Specificatie
        </div>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>❌ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (isset($product))
            <!-- WIREFRAME 03: Product Specification -->
            <div class="detail-section">
                <h2>📦 {{ $product->Naam }}</h2>
                <div class="product-info">
                    <div class="info-row">
                        <div class="info-label">Leverancier</div>
                        <div class="info-value">{{ $product->LeverancierNaam }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Barcode</div>
                        <div class="info-value">{{ $product->Barcode }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Aantal Leveringen</div>
                        <div class="info-value">{{ $deliveryCount }} {{$deliveryCount == 1 ? 'levering' : 'leveringen'}}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Totaal Aantal (in periode)</div>
                        <div class="info-value">{{ $totalQuantity }} stuks</div>
                    </div>
                </div>

                <!-- Allergens Section -->
                @if (count($allergens) > 0)
                    <div class="allergens">
                        <h4>⚠️ Allergenen</h4>
                        <div class="allergen-list">
                            @foreach ($allergens as $allergen)
                                <span class="allergen-badge">{{ $allergen->Naam }}</span>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="allergens">
                        <h4>✅ Allergenen</h4>
                        <div class="no-allergens">Dit product bevat geen bekende allergenen</div>
                    </div>
                @endif
            </div>

            <!-- Delivery Records -->
            <div class="detail-section">
                <h2>📋 Leveringen ({{ $startDate }} tot {{ $endDate }})</h2>

                @if ($deliveries && count($deliveries) > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Leverancier</th>
                                <th>Aantal</th>
                                <th>Verpakking</th>
                                <th>Datum Levering</th>
                                <th>Opmerking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliveries as $delivery)
                                <tr>
                                    <td>{{ $delivery->LeverancierNaam }}</td>
                                    <td><strong>{{ $delivery->Aantal }}</strong> stuks</td>
                                    <td>{{ $delivery->VerpakkingsEenheid }}</td>
                                    <td>
                                        @php
                                            $date = \DateTime::createFromFormat('Y-m-d', $delivery->DatumLevering);
                                            echo $date->format('d-m-Y');
                                        @endphp
                                    </td>
                                    <td>{{ $delivery->Opmerking ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-deliveries">
                        <p>Geen leveringen gevonden in de geselecteerde periode</p>
                        <p style="font-size: 13px; color: #aaa; margin-top: 10px;">
                            Periode: {{ $startDate }} tot {{ $endDate }}
                        </p>
                    </div>
                @endif
            </div>

            <a href="{{ route('producten.index', ['startDate' => $startDate, 'endDate' => $endDate]) }}" class="back-link">← Terug naar Overzicht</a>
        @else
            <div class="error">
                <p>❌ Product niet gevonden</p>
            </div>
            <a href="{{ route('producten.index') }}" class="back-link">← Terug naar Overzicht</a>
        @endif
    </div>

    <footer>
        © Jamin Bedrijf - User Story 01: Overzicht Geleverde Producten (Scenario 02)
    </footer>
</body>
</html>
