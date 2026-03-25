# Project Architecture - Opdracht 5 User Story 01

## Overall Architecture

```
┌─────────────────────────────────────────┐
│         USER BROWSER (HTTP)             │
└────────────────────┬────────────────────┘
                     │
        ┌────────────▼─────────────┐
        │    Laravel Router        │
        │  (routes/web.php)        │
        └────────────┬─────────────┘
                     │
        ┌────────────▼──────────────────────┐
        │   ProductLeveringController       │
        │  ├─ index() [Scenario 01]        │
        │  └─ specification() [Scenario 02] │
        └────────────┬──────────────────────┘
                     │
        ┌────────────▼──────────────────────┐
        │  Stored Procedures (via DB::*)    │
        │  ├─ GetProductsByDateRange        │
        │  ├─ GetProductSpecification       │
        │  ├─ GetAllergensForProduct        │
        │  └─ GetProductsWithoutLeveringen  │
        └────────────┬──────────────────────┘
                     │
        ┌────────────▼──────────────────────┐
        │      MySQL Database               │
        │  (7 tables + 4 stored procedures) │
        └──────────────────────────────────┘
```

## Directory Structure

```
opdracht5/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ProductLeveringController.php      # Main business logic
│   └── Models/                                     # 7 Eloquent models
│       ├── Contact.php
│       ├── Leverancier.php
│       ├── Allergeen.php
│       ├── Product.php
│       ├── ProductPerAllergeen.php
│       ├── ProductPerLeverancier.php
│       └── Magazijn.php
│
├── database/
│   ├── migrations/                               # 7 migration files
│   │   └── *_create_*_table.php
│   ├── seeders/
│   │   └── opdracht5Seeder.php                   # Test data (425 lines)
│   └── opdracht5.sql                             # Raw SQL schema + SPs
│
├── resources/
│   └── views/
│       ├── welcome.blade.php                     # Homepage (Wireframe 01)
│       └── producten/
│           ├── overzicht.blade.php               # Overview (Wireframe 02)
│           ├── specificatie.blade.php            # Details (Wireframe 03)
│           └── error.blade.php                   # No results (Wireframe 04)
│
├── routes/
│   └── web.php                                   # 2 routes configured
│
├── tests/
│   └── Feature/
│       └── ProductLeveringTest.php               # 5+ test cases
│
├── docs/
│   ├── DATABASE-SPECIFICATION.md                 # Table schemas
│   ├── ARCHITECTURE.md                           # This file
│   ├── Testplan.docx                             # Test scenarios
│   └── Testrapport.docx                          # Test results
│
└── public/
    └── (assets, if any)
```

## MVC Pattern Implementation

### Models (app/Models/)
Each model represents a database table with:
- Proper table name configuration
- Timestamp field mappings (DatumAangemaakt, DatumGewijzigd)
- Mass assignment protection via $fillable
- Relationships (hasMany, belongsTo, belongsToMany)

Example:
```php
class Product extends Model {
    protected $table = 'product';
    protected $fillable = ['Naam', 'Barcode', ...];
    
    public function allergeens() { 
        return $this->belongsToMany(...); 
    }
}
```

### Controllers (app/Http/Controllers)
Single controller (`ProductLeveringController`) with 2 public methods:

1. **index()** - Handles:
   - Initial load (all products)
   - Filtered loads (date range)
   - Manual pagination (4/page)
   - Scenario 03 error handling
   - Date format conversion (dd-mm-yyyy → yyyy-mm-dd)

2. **specification()** - Handles:
   - Product details display
   - Allergen retrieval
   - Delivery history in date range
   - Pagination of deliveries

### Views (resources/views/)
Four Blade templates matching assignment wireframes:

1. **welcome.blade.php** - Landing page with CTA
2. **producten/overzicht.blade.php** - Date filter form + product table + pagination
3. **producten/specificatie.blade.php** - Product details + allergens + deliveries
4. **producten/error.blade.php** - Error handling (Scenario 03)

## Data Flow

### Scenario 01: Product Overview
```
User Request (GET /producten)
    ↓
ProductLeveringController::index()
    ├─ Parse input: startDate, endDate, page
    ├─ Convert date format if filtering
    ├─ Call: CALL GetProductsByDateRange(startDate, endDate)
    ├─ Manual pagination: slice array into 4/page chunks
    └─ Return: products + pagination metadata
         ↓
    Blade view: overzicht.blade.php
         ├─ Show date filter form
         ├─ Render product table (sorted A-Z)
         ├─ Show pagination controls
         └─ Optional: Display error if no results (Scenario 03)
```

### Scenario 02: Product Specification
```
User Request (GET /producten/specificatie?productId=...&startDate=...&endDate=...)
    ↓
ProductLeveringController::specification()
    ├─ Validate parameters
    ├─ Fetch product info from database
    ├─ Call: CALL GetAllergensForProduct(productId)
    ├─ Call: CALL GetProductSpecification(productId, startDate, endDate)
    ├─ Calculate totals (sum quantities)
    └─ Return: product + allergens + deliveries
         ↓
    Blade view: specificatie.blade.php
         ├─ Show product details
         ├─ Show allergen badges
         ├─ Show delivery table
         └─ Pagination controls
```

## Database Design Patterns

### 1. Soft Deletes
All tables include `IsActief` (BIT) for logical deletion:
- Data retained for audit purposes
- Queries must filter WHERE IsActief = 1 (handled in SPs)

### 2. Audit Trail
All tables have:
- `DatumAangemaakt` - row insertion timestamp
- `DatumGewijzigd` - last modification timestamp
- Mapped to Laravel's timestamps (CREATED_AT, UPDATED_AT)

### 3. Foreign Key Relationships
```
Contact ←─ Leverancier ──→ ProductPerLeverancier ←─ Product ←─ ProductPerAllergeen ──→ Allergeen
                                                       └──→ Magazijn
```

Cascade deletes on:
- Product → ProductPerAllergeen (deleting product removes allergen links)
- Product → ProductPerLeverancier (deleting product removes deliveries)
- Leverancier → ProductPerLeverancier (deleting supplier removes deliveries)

### 4. Unique Constraints
- `Leverancier.LeverancierNummer` - supplier codes are unique
- `Product.Barcode` - product barcodes are unique
- `ProductPerAllergeen(ProductId, AllergeenId)` - prevent duplicate allergen links
- `Magazijn(ProductId, VerpakkingsEenheid)` - prevent duplicate stock entries

### 5. Indexing Strategy
Critical indexes for performance:
- `ProductPerLeverancier.DatumLevering` - date range filtering (Scenario 01)
- `ProductPerLeverancier.ProductId` - quick lookups (Scenario 02)
- `ProductPerLeverancier.LeverancierId` - supplier analytics

## API Contracts

### Route: GET /producten
**Query Parameters**:
- `startDate` (optional): dd-mm-yyyy format
- `endDate` (optional): dd-mm-yyyy format
- `page` (optional): 1-based page number

**Response Data**:
```php
[
    'products' => [...],  // Paginated array
    'pagination' => [
        'current_page' => int,
        'per_page' => 4,
        'total' => int,
        'last_page' => int,
        'from' => int,
        'to' => int,
    ],
    'startDate' => string,
    'endDate' => string,
    'hasFilter' => boolean,
    'hasResults' => boolean,
    'totalResults' => int,
]
```

### Route: GET /producten/specificatie
**Query Parameters**:
- `productId` (required): int
- `startDate` (required): dd-mm-yyyy or yyyy-mm-dd format
- `endDate` (required): dd-mm-yyyy or yyyy-mm-dd format

**Response Data**:
```php
[
    'product' => {...},     // Product object
    'allergens' => [...],   // Allergen array
    'deliveries' => [...],  // Paginated deliveries
    'pagination' => [...],
    'startDate' => string,
    'endDate' => string,
    'deliveryCount' => int,
    'totalQuantity' => int,
]
```

## Pagination Strategy

Manual pagination for stored procedure results:
```php
$perPage = 4;
$offset = ($page - 1) * $perPage;
$paginatedResults = $collection->slice($offset, $perPage);

$pagination = [
    'current_page' => $page,
    'per_page' => $perPage,
    'total' => count($collection),
    'last_page' => ceil(count($collection) / $perPage),
    'from' => $offset + 1,
    'to' => min($offset + $perPage, count($collection)),
];
```

Laravel's built-in paginator doesn't work directly with stored procedure results, so manual slicing is implemented.

## Error Handling

### Controller Level
- Date format validation (try-catch with custom error messages)
- Required parameter validation
- Product existence checks
- Redirect on error with meaningful messages

### View Level
- Display error messages via Laravel's $errors bag
- Conditional rendering for empty results (Scenario 03)
- User-friendly error messages in Dutch

## Security Measures

1. **CSRF Protection**: Laravel's @csrf token in forms (automatic)
2. **SQL Injection**: Protected via parameterized stored procedures
3. **Input Validation**: Date format validation before DB queries
4. **Authorization**: (Not required for this assignment, but structure ready)

## Testing Strategy

### PHPUnit Test Cases
```
ProductLeveringTest
├─ test_get_products_by_date_range()           # Scenario 01
├─ test_get_product_specification()            # Scenario 02
├─ test_no_deliveries_in_date_range()          # Scenario 03
├─ test_get_allergens_for_product()            # Allergens
└─ test_pagination_four_records_per_page()     # Pagination
```

Each test:
- Calls actual stored procedures
- Validates response structure
- Checks business logic (sorting, quantities, etc.)
- Verifies pagination behavior

## Performance Considerations

1. **Stored Procedures**: Complex business logic moved to database for efficiency
2. **Indexing**: Date and ID columns indexed for fast filtering
3. **Pagination**: Prevents loading thousands of records into PHP
4. **Lazy Loading**: Relationships can be eager loaded if needed

## Git Workflow

**Main Branch**: Production-ready code
**Development Branch**: `dev-opdracht-5-us01`

Commits include:
1. Initial commit - Database setup
2. Create Blade views
3. Controller implementation
4. Unit tests
5. Model relationships
6. Documentation
7. Bug fixes
8. Final polish
(10+ total commits)

## Deployment Checklist

- [ ] Copy project to production server
- [ ] Run `composer install --no-dev`
- [ ] Configure .env for production database
- [ ] Run `php artisan migrate` on MySQL 8.0 database
- [ ] Run `php artisan db:seed --class=opdracht5Seeder`
- [ ] Set proper file permissions (storage, bootstrap/cache)
- [ ] Cache configuration: `php artisan config:cache`
- [ ] Test all 3 scenarios manually
- [ ] Run `php artisan test` to verify tests pass
- [ ] Check error logs for any warnings

---

**Version**: 1.0
**Last Updated**: March 2026
**Status**: Production Ready
