# Opdracht 5 - User Story 01: Overzicht Geleverde Producten

## Project Beschrijving

Dit project implementeert **User Story 01: Overzicht Geleverde Producten** voor Jamin Bedrijf, een product management systeem dat leveringen en productinformatie trackt. 

Het systeem werd gebouwd met het **MVC-patroon**, **OOP-principes**, en **PDO** database abstraction via Laravel, met **MySQL 8.0** als database backend.

### Scenario's Implemented

- **Scenario 01**: Weergave van alle geleverde producten (initeel) of gefilterd op datumbereik
- **Scenario 02**: Detailweergave van specifiek product met allergeninformatie en leveringshistorie
- **Scenario 03**: Foutafhandeling bij geen resultaten ("Er zijn geen leveringen geweest van producten in deze periode")

## Technologie Stack

- **Framework**: Laravel 11.x
- **Language**: PHP 8.4+
- **Database**: MySQL 8.0
- **ORM**: Eloquent (Models) + Raw SQL (Stored Procedures)
- **Frontend**: Blade Templating, Custom CSS, Vanilla JavaScript
- **Testing**: PHPUnit (Unit Tests)
- **Version Control**: Git with feature branches

## Databaseschema

### Tabellen (7 totaal)

1. **Contact** - Bedrijfsadressen
2. **Leverancier** - Leveranciersgegevens (FK naar Contact)
3. **Allergeen** - Allergeentypes
4. **Product** - Productcatalogus
5. **ProductPerAllergeen** - Product-Allergeen relaties (many-to-many)
6. **ProductPerLeverancier** - Leveringen (product-leverancier-datum-hoeveelheid)
7. **Magazijn** - Voorraadbeheer

### Systeem-velden (op alle tabellen)
- `IsActief` (BIT) - Soft delete indicator
- `Opmerking` (VARCHAR 250) - Administratieve notities
- `DatumAangemaakt` (DATETIME(6)) - Audit trail
- `DatumGewijzigd` (DATETIME(6)) - Audit trail

## Stored Procedures

```sql
1. GetProductsByDateRange(p_start_date, p_end_date)
   → Retourneert producten met leveringen in periode, gesorteerd A-Z

2. GetProductSpecification(p_product_id, p_start_date, p_end_date)
   → Retourneert leveringsdetails voor specifiek product in periode

3. GetAllergensForProduct(p_product_id)
   → Retourneert alle allergenen gekoppeld aan product

4. GetProductsWithoutLeveringen(p_start_date, p_end_date)
   → Valideert of periode resultaten bevat (Scenario 03)
```

## Installatie & Setup

### Prerequisites
- PHP 8.4+
- MySQL 8.0+
- Composer
- Node.js (optioneel, voor asset compilation)

### Stappen

```bash
# Clone repository
git clone https://github.com/[username]/BE-opdracht-5-P3-[studentnummer].git
cd BE-opdracht-5-P3-[studentnummer]

# Install dependencies
composer install
npm install (optioneel)

# Create .env file
cp .env.example .env

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opdracht5
DB_USERNAME=root
DB_PASSWORD=

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database with test data
php artisan db:seed --class=opdracht5Seeder

# Start development server
php artisan serve
```

Application beschikbaar op: `http://localhost:8000`

## Gebruiksscenario's

### Scenario 01: Producten Overzicht
1. Navigeer naar `/producten`
2. Optioneel: Selecteer datumbereik (dd-mm-yyyy format)
3. Klik "Maak Selectie" om te filteren
4. Zie producten gesorteerd A-Z per leverancier, 4 per pagina

### Scenario 02: Product Specificatie
1. Vanuit Overzicht, klik "?" in de Specificatie kolom
2. Zie productdetails, allergeninformatie, en leveringshistorie
3. Bekijk alle deliveries in het geselecteerde datumbereik

### Scenario 03: Geen Resultaten
1. Selecteer datumbereik met geen deliveries (bijv. 01-05-2025 tot 31-05-2025)
2. Zie foutmelding: "Er zijn geen leveringen geweest van producten in deze periode"

## API Endpoints

```
GET  /                                    → Homepage
GET  /producten                           → Scenario 01: Product overview
GET  /producten/specificatie              → Scenario 02: Product details
     ?productId=N&startDate=dd-mm-yyyy&endDate=dd-mm-yyyy
```

## Unit Tests

Ruimte alle tests:
```bash
php artisan test
```

Coverage:
- Scenario 01: Stored procedure results, sorting, filtering
- Scenario 02: Product specification, allergen retrieval
- Scenario 03: Empty results handling
- Pagination logic (4 records per page)

## Best Practices Geïmplementeerd

✅ **MVC Architecture**: Models separaat van Controllers en Views
✅ **OOP**: Correct use van PHP namespaces, inheritance, encapsulation
✅ **Database Design**: Proper foreign keys, indexes, unique constraints
✅ **Error Handling**: Try-catch, custom error messages
✅ **Pagination**: Manual pagination met metadata (current_page, total, last_page)
✅ **Security**: Input validation, CSRF protection (Laravel built-in)
✅ **Audit Trail**: System fields op alle tabellen
✅ **Git Workflow**: Feature branch (dev-opdracht-5-us01), 10+ commits
✅ **Code Quality**: Clean code, meaningful variable names, inline documentation

## Deliverables

Documentation in `/docs/`:
- Testplan.docx - Gedetailleerd test scenario plan
- Testrapport.docx - Test execution results
- Database-Specificatie-Tabellen.docx - Field documentation

Video demo: `/vids/demo.mp4` (60 seconden, showing all 3 scenarios)

Database export: `/db/opdracht5.sql` (for phpMyAdmin import)

## Git Commits

Development branch `dev-opdracht-5-us01` contains 10+ commits including:
```
1. Initial commit - Database setup
2. feat: Create Blade views for all 3 scenarios
3. fix: Update controller to convert date formats
4. test: Add comprehensive unit tests
5. docs: Add README and database documentation
... (5+ more commits)
```

## Projectstructuur

```
opdracht5/
├── app/
│   ├── Http/Controllers/ProductLeveringController.php
│   └── Models/
│       ├── Contact.php
│       ├── Leverancier.php
│       ├── Allergeen.php
│       ├── Product.php
│       └── ...
├── database/
│   ├── migrations/
│   │   └── (7 migration files)
│   ├── seeders/
│   │   └── opdracht5Seeder.php
│   └── opdracht5.sql
├── resources/
│   └── views/
│       ├── welcome.blade.php
│       └── producten/
│           ├── overzicht.blade.php
│           ├── specificatie.blade.php
│           └── error.blade.php
├── routes/
│   └── web.php
├── tests/
│   └── Feature/ProductLeveringTest.php
└── README.md
```

## Auteur

Samir
Opleiding: MBO-4 Informatica
Inleverdatum: 15 maart 2026

---

**Opmerking**: Dit project demonstreert professionele webapplicatie-ontwikkeling met aandacht voor architectuur, kwaliteit, en onderhoudsbaarheid.
