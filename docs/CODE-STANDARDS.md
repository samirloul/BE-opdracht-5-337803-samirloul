# Code Standards & Best Practices - Opdracht 5

## PHP Code Style

### Naming Conventions

**Classes**: PascalCase
```php
class ProductLeveringController { }
class ProductPerLeverancier { }
```

**Methods/Functions**: camelCase
```php
public function getProductsByDateRange() { }
private function validateDateFormat() { }
```

**Variables**: camelCase
```php
$startDate = '2023-04-08';
$totalResults = count($products);
```

**Constants**: UPPER_SNAKE_CASE
```php
const MAX_RECORDS_PER_PAGE = 4;
const DATE_FORMAT = 'd-m-Y';
```

**Database Tables**: lowercase or capitalize
```
contact, product, product_per_leverancier
```

**Database Columns**: CamelCase (as per assignment spec)
```
IsActief, DatumAangemaakt, DatumGewijzigd
```

### Indentation & Formatting

- **Indentation**: 4 spaces (NOT tabs)
- **Line Length**: 100 characters maximum
- **Opening Braces**: Same line (Allman style)
```php
public function index() {
    if ($condition) {
        // code
    }
}
```

### Comments

**Class Level Documentation**:
```php
/**
 * Class ProductLeveringController
 * 
 * Handles all product delivery overview scenarios
 * - Scenario 01: Product overview with date filtering
 * - Scenario 02: Product specification details
 * - Scenario 03: No results error handling
 */
class ProductLeveringController extends Controller {
```

**Method Documentation**:
```php
/**
 * Retrieve products filtered by delivery date range
 * 
 * @param Request $request
 * @return \Illuminate\View\View
 */
public function index(Request $request) {
```

**Inline Comments** (for complex logic):
```php
// Convert dd-mm-yyyy format to yyyy-mm-dd for database
$dateStart = DateTime::createFromFormat('d-m-Y', $startDateInput);
$startDate = $dateStart->format('Y-m-d');
```

## Blade Templates

### HTML Structure

**Indentation**: 2 spaces (lighter than PHP)
```html
<div class="container">
  <form method="GET">
    <input type="text" name="startDate">
  </form>
</div>
```

### Blade Directives

**Conditionals**:
```html
@if ($condition)
    {{ __('message') }}
@else
    {{ __('other') }}
@endif
```

**Loops**:
```html
@forelse ($products as $product)
    <tr>
        <td>{{ $product->Naam }}</td>
    </tr>
@empty
    <tr><td>No products</td></tr>
@endforelse
```

**Route Generation** (always use named routes):
```html
<!-- Good -->
<a href="{{ route('producten.index') }}">Products</a>

<!-- Bad -->
<a href="/producten">Products</a>
```

## Database Best Practices

### Query Structure

**Always use stored procedures for complex queries**:
```php
// Good
$results = DB::select('CALL GetProductsByDateRange(?, ?)', [$start, $end]);

// Bad (simple queries OK)
$results = DB::table('products')->where('IsActief', 1)->get();
```

### Foreign Key Usage

**Always specify relationships in models**:
```php
class ProductPerLeverancier extends Model {
    public function leverancier() {
        return $this->belongsTo(Leverancier::class, 'LeverancierId', 'Id');
    }
}
```

### NULL Handling

**Use explicit NULL checks**:
```php
// Good
if ($product->Opmerking !== null) {
    // handle
}

// Also OK
if (!is_null($product->Opmerking)) {
    // handle
}

// Bad
if ($product->Opmerking) {
    // handle
}
```

## Testing Standards

### Test Class Structure

```php
class ProductLeveringTest extends TestCase {
    /**
     * Test description matching the test
     * 
     * @test
     */
    public function test_get_products_by_date_range() {
        // Arrange
        $startDate = '2023-04-08';
        
        // Act
        $products = DB::select('CALL GetProductsByDateRange(?, ?)', [$startDate, $endDate]);
        
        // Assert
        $this->assertGreaterThan(0, count($products));
    }
}
```

**Test Naming**:
- Always start with `test_`
- Describe what is being tested
- Use underscore_separated names

## Code Quality Checklist

Before committing:

- [ ] No syntax errors (`php -l` on files)
- [ ] Variable names are descriptive
- [ ] Comments explain WHY, not WHAT
- [ ] No hardcoded values (use constants)
- [ ] Error handling is in place
- [ ] SQL is parameterized (no injection risk)
- [ ] HTML output is escaped ({{ }} not {!! !!})
- [ ] No console.log or dd() left in code
- [ ] No TODO or FIXME comments without context
- [ ] Code follows PSR-12 standards
- [ ] All tests pass

## File Structure

### Controllers
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller {
    
    // Constants
    const RECORDS_PER_PAGE = 4;
    
    // Public methods
    public function index() { }
    public function specification() { }
    
    // Protected methods
    protected function validateDates() { }
    
    // Private methods
    private function formatDate() { }
}
```

### Models
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model extends \Illuminate\Database\Eloquent\Model {
    
    // Configuration
    public $timestamps = true;
    protected $table = 'table_name';
    protected $fillable = [];
    
    // Relationships
    public function relation() { }
    
    // Accessors/Mutators (if needed)
    public function getAttribute() { }
}
```

## Error Messages

Use clear, user-friendly error messages in Dutch:

**Good**:
- "Ongeldige datumformat. Gebruik dd-mm-yyyy"
- "Product niet gevonden"
- "Er zijn geen leveringen geweest van producten in deze periode"

**Bad**:
- "Error"
- "Database error 1054"
- "Invalid input"

## Security Practices

### Input Validation
```php
// Always validate user input
$validated = $request->validate([
    'startDate' => 'required|date_format:d-m-Y',
    'endDate' => 'required|date_format:d-m-Y|after:startDate',
]);
```

### SQL Injection Prevention
```php
// Good - Parameterized
DB::select('SELECT * FROM products WHERE id = ?', [$id]);

// Bad - String interpolation
DB::select("SELECT * FROM products WHERE id = $id");
```

### XSS Prevention
```php
// Good - Auto-escaped
{{ $variable }}

// Only use unescaped if absolutely necessary
{!! $trustedHtml !!}
```

## Git Commit Messages

### Format
```
<type>: <subject>

<body>

<footer>
```

### Types
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation
- `style`: Formatting, missing semicolons, etc.
- `refactor`: Code restructuring
- `test`: Adding tests
- `chore`: Build process, dependencies

### Examples
```
feat: Add product filtering by date range

Implements Scenario 01 with date picker and manual pagination.
Supports dd-mm-yyyy format conversion to database format.

Closes #5

---

fix: Update controller date conversion logic

DatumLevering column now correctly filtered for date ranges.

---

docs: Add API documentation

Comprehensive endpoint specifications and examples.
```

## Code Review Checklist

When reviewing pull requests:

- [ ] Code follows naming conventions
- [ ] Comments explain complex logic
- [ ] No dead code
- [ ] Tests are included
- [ ] Database queries are optimized
- [ ] No hardcoded values
- [ ] Error handling present
- [ ] Security best practices followed

## Performance Guidelines

### Avoid
- N+1 queries (use eager loading)
- Loading entire tables into memory
- Nested loops over large datasets
- Unnecessary database round-trips

### Use
- Stored procedures for complex queries
- Indexing on frequently filtered columns
- Pagination for large result sets
- Query caching when appropriate

## Documentation Standard

Every major feature should have:

1. **Inline comments** in code
2. **PHPDoc** for public methods
3. **README** section or separate document
4. **Test cases** demonstrating usage

## Refactoring Guidelines

When refactoring:

1. Ensure all tests pass first
2. Make one change at a time
3. Commit after each successful refactoring
4. Use meaningful commit messages
5. Never refactor and add features simultaneously

---

**Version**: 1.0
**Last Updated**: March 2026
**Status**: Guidelines for this project
