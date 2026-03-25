# Opdracht 5 - SQL Joins (Laravel)

Dit project is een complete uitwerking van opdracht 5 met:

- Laravel (PHP backend)
- Blade (HTML templates)
- CSS (eigen styling)
- JavaScript (filter en animatie)
- SQL (joins + seed data)

## Wat zit erin?

- Datamodel met `students`, `courses` en `enrollments`
- Voorbeelddata via seeder
- Overzichtspagina met:
	- INNER JOIN
	- LEFT JOIN
	- RIGHT JOIN (equivalent voor SQLite)
	- FULL OUTER JOIN (gesimuleerd met `UNION`)
	- Left/Right/Full Exclusive joins
- SQL-codevoorbeelden op de pagina

## Starten

1. Installeer dependencies

```bash
composer install
npm install
```

2. Database opbouwen

```bash
php artisan migrate:fresh --seed
```

3. Frontend bouwen

```bash
npm run build
```

4. Applicatie starten

```bash
php artisan serve
```

Open daarna `http://127.0.0.1:8000`.

## Belangrijke bestanden

- `routes/web.php` - routes
- `app/Http/Controllers/JoinDemoController.php` - querylogica
- `resources/views/joins-dashboard.blade.php` - pagina
- `resources/css/app.css` - styling
- `resources/js/app.js` - interactie
- `database/migrations/*` - tabellen
- `database/seeders/DatabaseSeeder.php` - testdata
- `database/opdracht5.sql` - losse SQL script versie
