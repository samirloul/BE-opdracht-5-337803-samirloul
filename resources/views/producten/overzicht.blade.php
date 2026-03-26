<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht geleverde producten</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        header { background: #2c3e50; color: white; padding: 20px 0; margin-bottom: 30px; }
        header h1 { margin: 0; }
        
        .filter-section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .filter-section h2 { margin-bottom: 15px; color: #2c3e50; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group input { padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; width: 200px; }
        .form-group button { padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .form-group button:hover { background: #229954; }
        
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb; }
        .toolbar { background: #fff; padding: 14px 16px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 16px; }
        
        .table-section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .table-section h2 { margin-bottom: 15px; color: #2c3e50; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #34495e; color: white; padding: 12px; text-align: left; font-weight: bold; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f9f9f9; }
        
        .no-results { text-align: center; padding: 20px; color: #666; }
        
        .spec-link { color: #2c3e50; text-decoration: none; font-weight: bold; cursor: pointer; }
        .spec-link:hover { text-decoration: underline; }
        
        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #2c3e50; }
        .pagination a:hover { background: #2c3e50; color: white; }
        .pagination .active { background: #2c3e50; color: white; border-color: #2c3e50; }
        .pagination .disabled { color: #ccc; cursor: not-allowed; }
        
        .breadcrumb { margin-bottom: 16px; color: #555; font-size: 14px; }
        .breadcrumb a { color: #2c3e50; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        .filter-section { background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 20px; box-shadow: none; }
        .filter-section h2 { margin-bottom: 16px; color: #2c3e50; font-size: 18px; }
        
        .filter-form { display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap; }
        .form-group { display: flex; flex-direction: column; margin-bottom: 0; }
        .form-group label { margin-bottom: 6px; font-weight: bold; color: #2c3e50; font-size: 14px; }
        .form-group input { padding: 9px 10px; border: 1px solid #bbb; border-radius: 4px; font-size: 14px; background: white; min-width: 190px; }
        .form-group input:focus { outline: none; border-color: #2c3e50; }
        
        .filter-actions { display: flex; gap: 10px; }
        .filter-actions button { padding: 10px 16px; background: #2c3e50; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 14px; }
        .filter-actions button:hover { background: #1f2d3a; }
        
        .reset-btn { background: #7f8c8d !important; }
        .reset-btn:hover { background: #6c7a89 !important; }
        
        footer { margin-top: 30px; padding: 16px; text-align: center; color: #666; font-size: 12px; }
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
            <a href="{{ url('/') }}">Home</a> / Overzicht geleverde producten
        </div>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- WIREFRAME 02: Filter Form -->
        <div class="filter-section">
            <h2>Overzicht geleverde producten</h2>
            <form method="GET" action="{{ route('producten.index') }}">
                <div class="filter-form">
                    <div class="form-group" style="flex: 1; min-width: 200px;">
                        <label for="startDate">Startdatum</label>
                        <input type="text" id="startDate" name="startDate" placeholder="dd-mm-jjjj" value="{{ old('startDate', $startDate) }}">
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 200px;">
                        <label for="endDate">Einddatum</label>
                        <input type="text" id="endDate" name="endDate" placeholder="dd-mm-jjjj" value="{{ old('endDate', $endDate) }}">
                    </div>
                    <div class="filter-actions">
                        <button type="submit">Maak Selectie</button>
                        <button type="button" class="reset-btn" onclick="window.location='{{ route('producten.index') }}'">Reset</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- WIREFRAME 02/04: Product Table -->
        <div class="table-section">
            <h2>
                @if (!$hasFilter)
                    Overzicht geleverde producten
                @else
                    Overzicht geleverde producten ({{ $startDate }} t/m {{ $endDate }})
                @endif
            </h2>

            <table>
                <thead>
                    <tr>
                        <th>Naam leverancier</th>
                        <th>Contactpersoon</th>
                        <th>Productnaam</th>
                        <th>Totaal geleverd</th>
                        <th>Specificatie</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products->count() > 0)
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->LeverancierNaam }}</td>
                                <td>{{ $product->ContactPersoon ?? '-' }}</td>
                                <td>{{ $product->Naam }}</td>
                                <td>{{ $product->TotalAantal }}</td>
                                <td>
                                    <a href="{{ route('producten.specification', ['productId' => $product->Id, 'startDate' => $startDate ?: '2000-01-01', 'endDate' => $endDate ?: now()->toDateString()]) }}" class="spec-link">?</a>
                                </td>
                            </tr>
                        @endforeach
                    @elseif ($hasFilter && !$hasResults)
                        <tr>
                            <td colspan="5" class="no-results">Er zijn geen leveringen geweest van producten in deze periode</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" class="no-results">Geen gegevens gevonden</td>
                        </tr>
                    @endif
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
        </div>
    </div>

    <footer>
        Jamin Bedrijf
    </footer>
</body>
</html>
