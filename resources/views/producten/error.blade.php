<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fout - Jamin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        header { background: #2c3e50; color: white; padding: 20px 0; margin-bottom: 30px; }
        header h1 { margin: 0 0 10px 0; }
        header a { color: white; text-decoration: none; }
        header a:hover { text-decoration: underline; }
        
        .error-container { text-align: center; padding: 60px 20px; }
        .error-icon { font-size: 80px; margin-bottom: 20px; }
        .error-title { font-size: 32px; color: #c0392b; margin-bottom: 15px; font-weight: bold; }
        .error-message { font-size: 18px; color: #555; margin-bottom: 30px; line-height: 1.6; }
        .error-details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #c0392b; }
        .error-details p { color: #888; font-size: 14px; margin-bottom: 10px; }
        .error-details strong { color: #333; }
        
        .back-button { display: inline-block; padding: 12px 30px; background: #27ae60; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; margin-top: 20px; transition: 0.3s; }
        .back-button:hover { background: #229954; }
        
        footer { margin-top: 60px; padding: 20px; text-align: center; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Jamin Bedrijf</h1>
            <a href="/">← Terug naar Home</a>
        </div>
    </header>

    <div class="container">
        <!-- WIREFRAME 04: No Results / Error State -->
        <div class="error-container">
            <div class="error-icon">📦</div>
            <h1 class="error-title">Geen Resultaten</h1>
            <div class="error-message">
                {{ $message ?? "Er zijn geen leveringen geweest van producten in deze periode" }}
            </div>
            
            <div class="error-details">
                <p><strong>Waarom ziet u dit bericht?</strong></p>
                <p>De zoekcriteria hebben geen overeenkomende gegevens opgeleverd. Controleer de ingevulde datums en probeer een ander datumbereik.</p>
            </div>

            <div style="background: #f0f0f0; padding: 15px; border-radius: 4px; margin: 20px auto; max-width: 400px; font-size: 13px;">
                <p><strong>Tip:</strong> Probeer bijvoorbeeld een datumbereik van <code>08-04-2023</code> tot <code>19-04-2023</code></p>
            </div>

            <a href="{{ route('producten.index') }}" class="back-button">← Terug naar Overzicht</a>
        </div>
    </div>

    <footer>
        © Jamin Bedrijf - User Story 01: Overzicht Geleverde Producten (Scenario 03)
    </footer>
</body>
</html>
