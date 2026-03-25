<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jamin Bedrijf - Overzicht Geleverde Producten</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; flex-direction: column; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: center; }
        
        .content { background: white; padding: 60px 40px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); text-align: center; }
        
        .logo { font-size: 64px; margin-bottom: 20px; }
        
        h1 { color: #2c3e50; font-size: 42px; margin-bottom: 10px; }
        .subtitle { color: #7f8c8d; font-size: 18px; margin-bottom: 30px; font-weight: 300; }
        
        .description { max-width: 600px; margin: 0 auto 40px; color: #555; font-size: 15px; line-height: 1.8; }
        
        .cta-button { display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); cursor: pointer; border: none; }
        .cta-button:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6); }
        
        .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 50px; max-width: 900px; margin-left: auto; margin-right: auto; }
        
        .feature { background: #f8f9fa; padding: 25px; border-radius: 8px; }
        .feature-icon { font-size: 40px; margin-bottom: 15px; }
        .feature-title { color: #2c3e50; font-weight: bold; margin-bottom: 10px; }
        .feature-desc { color: #7f8c8d; font-size: 13px; line-height: 1.6; }
        
        footer { background: rgba(0,0,0,0.1); color: white; text-align: center; padding: 20px; margin-top: auto; }
        footer p { margin: 5px 0; font-size: 13px; }
        
        @media (max-width: 768px) {
            .content { padding: 40px 20px; }
            h1 { font-size: 28px; }
            .features { grid-template-columns: 1fr; gap: 20px; }
            .cta-button { padding: 12px 30px; font-size: 14px; }
        }
    </style>
</head>
<body>
    <!-- WIREFRAME 01: Homepage with CTA -->
    <div class="container">
        <div class="content">
            <div class="logo">📦</div>
            <h1>Jamin Bedrijf</h1>
            <p class="subtitle">Management Systeem voor Geleverde Producten</p>
            
            <div class="description">
                <p>
                    Welkom bij het Jamin Management Systeem. Met deze toepassing kunt u eenvoudig 
                    alle geleverde producten en leveranciersinformatie raadplegen. 
                    Bekijk specifieke productgegevens, allergeninformatie en leveringsdatums.
                </p>
            </div>

            <a href="{{ route('producten.index') }}" class="cta-button">
                → Ga naar Overzicht Geleverde Producten
            </a>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">📊</div>
                    <div class="feature-title">Datumfilter</div>
                    <div class="feature-desc">Filter producten op leveringsdatum voor rapportage en analyse</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">⚠️</div>
                    <div class="feature-title">Allergeninformatie</div>
                    <div class="feature-desc">Zie welke allergenen in elk product aanwezig zijn</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">📦</div>
                    <div class="feature-title">Leverancierdetails</div>
                    <div class="feature-desc">Volledige informatie over alle leveranciers en leveringen</div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p><strong>Jamin Bedrijf</strong> © 2026 | User Story 01: Overzicht Geleverde Producten</p>
        <p>Ingebouwd met Laravel • MySQL • Blade Templating</p>
    </footer>
</body>
</html>
