<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 900px; margin: 80px auto; padding: 20px; }
        .card { background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 28px; }
        h1 { font-size: 32px; margin-bottom: 16px; color: #2c3e50; }
        .home-link { display: inline-block; margin-top: 8px; font-size: 22px; color: #2c3e50; text-decoration: none; border-bottom: 2px solid #2c3e50; }
        .home-link:hover { color: #1f2d3a; border-bottom-color: #1f2d3a; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Homepage</h1>
            <a href="{{ route('producten.index') }}" class="home-link">Overzicht geleverde producten</a>
        </div>
    </div>
</body>
</html>
