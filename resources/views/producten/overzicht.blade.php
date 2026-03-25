<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Geleverde Producten - Jamin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        header { background: #2c3e50; color: white; padding: 20px 0; margin-bottom: 30px; }
        header h1 { margin: 0 0 10px 0; }
        header a { color: white; text-decoration: none; margin-right: 20px; }
        header a:hover { text-decoration: underline; }
        
        .filter-section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .filter-section h2 { margin-bottom: 15px; color: #2c3e50; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group input { padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; width: 200px; }
        .form-group button { padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .form-group button:hover { background: #229954; }
        
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #c3e6cb; }
        
        .table-section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .table-section h2 { margin-bottom: 15px; color: #2c3e50; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #34495e; color: white; padding: 12px; text-align: left; font-weight: bold; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f9f9f9; }
        
        .no-results { text-align: center; padding: 40px 20px; color: #888; }
        .no-results p { font-size: 16px; margin-bottom: 20px; }
        
        .spec-link { color: #27ae60; text-decoration: none; font-weight: bold; cursor: pointer; }
        .spec-link:hover { text-decoration: underline; }
        
        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #27ae60; }
        .pagination a:hover { background: #27ae60; color: white; }
        .pagination .active { background: #27ae60; color: white; border-color: #27ae60; }
        .pagination .disabled { color: #ccc; cursor: not-allowed; }
        
        .breadcrumb { margin-bottom: 20px; color: #888; font-size: 13px; }
        .breadcrumb a { color: #27ae60; text-decoration: none; }
        
        /* Enhanced navigation bar */
        .navbar { background: white; border-bottom: 2px solid #27ae60; padding: 15px 0; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .breadcrumb-nav { display: flex; align-items: center; gap: 10px; max-width: 1200px; margin: 0 auto; padding: 0 20px; font-size: 14px; }
        .breadcrumb-nav a { color: #27ae60; text-decoration: none; font-weight: 500; transition: all 0.3s ease; padding: 5px 10px; border-radius: 4px; }
        .breadcrumb-nav a:hover { background: #ecf0f1; color: #229954; }
        .breadcrumb-nav .separator { color: #bbb; margin: 0 5px; }
        .breadcrumb-nav .active { color: #2c3e50; font-weight: 600; }
        
        /* Improved filter section */
        .filter-section { background: linear-gradient(135deg, #ffffff 0%, #f8fafb 100%); padding: 30px; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 5px solid #27ae60; }
        .filter-section h2 { margin-bottom: 20px; color: #2c3e50; font-size: 18px; display: flex; align-items: center; gap: 8px; }
        .filter-section h2::before { content: "📅"; }
        
        .filter-form { display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 8px; font-weight: 600; color: #2c3e50; font-size: 14px; }
        .form-group input { padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px; transition: all 0.3s ease; background: white; }
        .form-group input:focus { outline: none; border-color: #27ae60; box-shadow: 0 0 8px rgba(39, 174, 96, 0.15); }
        .form-group input::placeholder { color: #bbb; }
        
        .filter-actions { display: flex; gap: 10px; }
        .filter-actions button { padding: 12px 30px; background: #27ae60; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(39, 174, 96, 0.2); }
        .filter-actions button:hover { background: #229954; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3); }
        .filter-actions button:active { transform: translateY(0); }
        
        .reset-btn { background: #95a5a6 !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important; }
        .reset-btn:hover { background: #7f8c8d !important; }
        
        footer { margin-top: 40px; padding: 20px; text-align: center; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Jamin Bedrijf</h1>
        </div>
    </header>

    <nav class="navbar">
        <div class="breadcrumb-nav">
            <a href="/" title="Terug naar homepagina">🏠 Home</a>
            <span class="separator">/</span>
            <span class="active">📦 Overzicht Geleverde Producten</span>
        </div>
    </nav>

    <div class="container">

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>❌ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- WIREFRAME 02: Filter Form -->
        <div class="filter-section">
            <h2>Datumfilter</h2>
            <form method="GET" action="{{ route('producten.index') }}">
                <div class="filter-form">
                    <div class="form-group" style="flex: 1; min-width: 200px;">
                        <label for="startDate">📅 Startdatum</label>
                        <input type="text" id="startDate" name="startDate" placeholder="dd-mm-yyyy (bijv. 01-04-2023)" value="{{ old('startDate', $startDate) }}" title="Voer datum in formaat dd-mm-yyyy in">
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 200px;">
                        <label for="endDate">📅 Einddatum</label>
                        <input type="text" id="endDate" name="endDate" placeholder="dd-mm-yyyy (bijv. 30-04-2023)" value="{{ old('endDate', $endDate) }}" title="Voer datum in formaat dd-mm-yyyy in">
                    </div>
                    <div class="filter-actions">
                        <button type="submit">✓ Zoeken</button>
                        <button type="button" class="reset-btn" onclick="window.location='{{ route('producten.index') }}'" title="Filter verwijderen">Alles Weergeven</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- WIREFRAME 04: No Results Message -->
        @if ($hasFilter && !$hasResults)
            <div class="table-section">
                <div class="no-results">
                    <p>📦 Er zijn geen leveringen geweest van producten in deze periode</p>
                    <p style="font-size: 13px; color: #aaa;">Probeer een ander datumbereik</p>
                </div>
            </div>
        @else
            <!-- WIREFRAME 02: Product Table (Scenarios 01 + initial) -->
            <div class="table-section">
                <h2>
                    @if (!$hasFilter)
                        Alle Geleverde Producten (ooit tot vandaag)
                    @else
                        Geleverde Producten ({{ $startDate }} t/m {{ $endDate }})
                    @endif
                </h2>

                @if ($products->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Leverancier</th>
                                <th>Totaal Aantal</th>
                                <th>Leveringen</th>
                                <th>Specificatie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><strong>{{ $product->Naam }}</strong></td>
                                    <td>{{ $product->LeverancierNaam }}</td>
                                    <td>{{ $product->TotalAantal }} stuks</td>
                                    <td>{{ $product->AantalLeveringen }} {{$product->AantalLeveringen == 1 ? 'levering' : 'leveringen'}}</td>
                                    <td>
                                        <a href="{{ route('producten.specification', ['productId' => $product->Id, 'startDate' => $startDate ?: '2000-01-01', 'endDate' => $endDate ?: now()->toDateString()]) }}" class="spec-link">?</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if ($pagination['last_page'] > 1)
                        <div class="pagination">
                            @if ($pagination['current_page'] > 1)
                                <a href="{{ route('producten.index', array_merge(request()->query(), ['page' => 1])) }}">« Eerste</a>
                                <a href="{{ route('producten.index', array_merge(request()->query(), ['page' => $pagination['current_page'] - 1])) }}">‹ Vorige</a>
                            @else
                                <span class="disabled">« Eerste</span>
                                <span class="disabled">‹ Vorige</span>
                            @endif

                            @for ($i = 1; $i <= $pagination['last_page']; $i++)
                                @if ($i == $pagination['current_page'])
                                    <span class="active">{{ $i }}</span>
                                @else
                                    <a href="{{ route('producten.index', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($pagination['current_page'] < $pagination['last_page'])
                                <a href="{{ route('producten.index', array_merge(request()->query(), ['page' => $pagination['current_page'] + 1])) }}">Volgende ›</a>
                                <a href="{{ route('producten.index', array_merge(request()->query(), ['page' => $pagination['last_page']])) }}">Laatste »</a>
                            @else
                                <span class="disabled">Volgende ›</span>
                                <span class="disabled">Laatste »</span>
                            @endif
                        </div>
                        <div style="text-align: center; font-size: 12px; color: #888; margin-top: 10px;">
                            Getoond {{ $pagination['from'] }} tot {{ $pagination['to'] }} van {{ $pagination['total'] }} resultaten
                        </div>
                    @endif
                @else
                    <div class="no-results">
                        <p>Geen producten gevonden</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <footer>
        © Jamin Bedrijf - User Story 01: Overzicht Geleverde Producten (Scenario 01)
    </footer>

    <script>
        // Simple date picker help (optional: add better date library if needed)
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    // Add client-side date validation if needed
                });
            });
        });
    </script>
</body>
</html>
