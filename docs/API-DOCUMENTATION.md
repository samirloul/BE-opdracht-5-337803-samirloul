# API Documentation - Opdracht 5 User Story 01

## Base URL
```
http://localhost:8000
```

## Endpoints

### 1. GET /
**Purpose**: Homepage with project information and CTA

**Response**: HTML page (Wireframe 01)
- Displays welcome message
- Features overview
- Link to product overview

**Status Codes**:
- 200: OK

---

### 2. GET /producten
**Purpose**: Product overview with optional date filtering (Scenario 01)

**Query Parameters**:
| Parameter | Type | Required | Format | Example |
|-----------|------|----------|--------|---------|
| startDate | string | No | dd-mm-yyyy | 08-04-2023 |
| endDate | string | No | dd-mm-yyyy | 19-04-2023 |
| page | integer | No | integer | 1 |

**Behavior**:

#### Initial Load (No Parameters)
- Returns ALL products ever delivered
- Sorted A-Z by Leverancier name
- 4 records per page
- Shows total product count

#### With Date Filter
- Returns products delivered ONLY in specified date range
- Sorted A-Z by Leverancier name
- 4 records per page
- If no results → shows error message (Scenario 03)

#### Date Format Requirements
- MUST be dd-mm-yyyy format
- Example: 08-04-2023 (not 2023-04-08)
- Invalid format → redirects with error message

**Calls Stored Procedure**:
```sql
CALL GetProductsByDateRange('yyyy-mm-dd', 'yyyy-mm-dd')
```

**Response Data**:
```php
{
    "products": [
        {
            "Id": 1,
            "Naam": "Mintnopjes",
            "LeverancierNaam": "Basset",
            "TotalAantal": 100,
            "AantalLeveringen": 2
        },
        ...
    ],
    "pagination": {
        "current_page": 1,
        "per_page": 4,
        "total": 12,
        "last_page": 3,
        "from": 1,
        "to": 4
    },
    "startDate": "08-04-2023",
    "endDate": "19-04-2023",
    "hasFilter": true,
    "hasResults": true,
    "totalResults": 12
}
```

**Status Codes**:
- 200: OK - Products successfully retrieved
- 302: Redirect - Invalid date format or error condition

**Example Requests**:
```bash
# All products
GET /producten HTTP/1.1

# Products in April 2023
GET /producten?startDate=08-04-2023&endDate=19-04-2023 HTTP/1.1

# Page 2 of results
GET /producten?startDate=08-04-2023&endDate=19-04-2023&page=2 HTTP/1.1

# No results scenario (future date)
GET /producten?startDate=01-05-2025&endDate=31-05-2025 HTTP/1.1
```

**Validation Rules**:
```php
startDate format: dd-mm-yyyy (required if endDate provided)
endDate format: dd-mm-yyyy (required if startDate provided)
endDate MUST be after startDate
```

**Error Responses**:
```html
<!-- Invalid date format -->
{
    "errors": ["Ongeldige datumformat. Gebruik dd-mm-yyyy"]
}

<!-- Scenario 03: No results -->
Page displays: "Er zijn geen leveringen geweest van producten in deze periode"
```

---

### 3. GET /producten/specificatie
**Purpose**: Product detail view with allergen info and delivery history (Scenario 02)

**Query Parameters** (All Required):
| Parameter | Type | Required | Format | Example |
|-----------|------|----------|--------|---------|
| productId | integer | Yes | integer | 3 |
| startDate | string | Yes | dd-mm-yyyy or yyyy-mm-dd | 08-04-2023 |
| endDate | string | Yes | dd-mm-yyyy or yyyy-mm-dd | 19-04-2023 |
| page | integer | No | integer | 1 |

**Calls Stored Procedures**:
```sql
CALL GetAllergensForProduct(productId)
CALL GetProductSpecification(productId, 'yyyy-mm-dd', 'yyyy-mm-dd')
```

**Response Data**:
```php
{
    "product": {
        "Id": 3,
        "Naam": "Schoolkrijt",
        "Barcode": "8717064255555",
        "LeverancierNaam": "Venco"
    },
    "allergens": [
        {
            "Naam": "Gluten"
        },
        {
            "Naam": "Lactose"
        }
    ],
    "deliveries": [
        {
            "LeverancierNaam": "Venco",
            "Aantal": 50,
            "VerpakkingsEenheid": "0.5",
            "DatumLevering": "2023-04-10",
            "Opmerking": null
        },
        ...
    ],
    "pagination": {
        "current_page": 1,
        "per_page": 4,
        "total": 2,
        "last_page": 1,
        "from": 1,
        "to": 2
    },
    "startDate": "08-04-2023",
    "endDate": "19-04-2023",
    "deliveryCount": 2,
    "totalQuantity": 150
}
```

**Status Codes**:
- 200: OK - Product details successfully retrieved
- 302: Redirect - Invalid parameters or product not found

**Example Requests**:
```bash
# Get product 3 deliveries for April 8-19, 2023
GET /producten/specificatie?productId=3&startDate=08-04-2023&endDate=19-04-2023 HTTP/1.1

# Page 2 of deliveries
GET /producten/specificatie?productId=3&startDate=08-04-2023&endDate=19-04-2023&page=2 HTTP/1.1

# Alternative date format (also accepted)
GET /producten/specificatie?productId=3&startDate=2023-04-08&endDate=2023-04-19 HTTP/1.1
```

**Validation Rules**:
```php
productId: must exist in products table
startDate: dd-mm-yyyy or yyyy-mm-dd format required
endDate: dd-mm-yyyy or yyyy-mm-dd format required
```

**Error Responses**:
```json
{
    "errors": ["Ongeldige parameters"]
}
```

---

## HTTP Status Codes

| Code | Meaning | Scenario |
|------|---------|----------|
| 200 | OK | Data successfully retrieved |
| 302 | Redirect | Invalid input or error condition |
| 404 | Not Found | Route not found |
| 500 | Server Error | Database connection issue |

---

## Response Format

All responses follow Laravel conventions:
- Blade templating for HTML views
- Error messages in `$errors` array (available in templates)
- Pagination metadata in `$pagination` variable

---

## Example: Complete User Journey

### Scenario 01 Complete Flow
```bash
# 1. User visits homepage
GET / HTTP/1.1
← Returns: welcome.blade.php (Wireframe 01)

# 2. User clicks "Ga naar Overzicht"
GET /producten HTTP/1.1
← Returns: All products, 4 per page (Wireframe 02)

# 3. User enters date range and clicks "Maak Selectie"
GET /producten?startDate=08-04-2023&endDate=19-04-2023 HTTP/1.1
← Returns: Filtered products for date range

# 4. Check pagination page 2
GET /producten?startDate=08-04-2023&endDate=19-04-2023&page=2 HTTP/1.1
← Returns: Next 4 products
```

### Scenario 02 Complete Flow
```bash
# 1. From overview, user clicks "?" for product 3
GET /producten/specificatie?productId=3&startDate=08-04-2023&endDate=19-04-2023 HTTP/1.1
← Returns: Product details + allergens + deliveries (Wireframe 03)

# 2. User clicks back button
← Returns to Scenario 01 overview
```

### Scenario 03 Complete Flow
```bash
# 1. User enters future date with no deliveries
GET /producten?startDate=01-05-2025&endDate=31-05-2025 HTTP/1.1
← Returns: Error message page (Wireframe 04)
→ Displays: "Er zijn geen leveringen geweest van producten in deze periode"
```

---

## Content Types

All responses are:
- **Type**: text/html
- **Charset**: UTF-8
- **Language**: Dutch (nl)

---

## Pagination Details

- **Records per page**: 4 (fixed)
- **Metadata fields**:
  - `current_page`: 1-based page number
  - `per_page`: Always 4
  - `total`: Total record count
  - `last_page`: Maximum page number
  - `from`: First record number on current page
  - `to`: Last record number on current page

**Example**:
```php
// Page 1
from: 1, to: 4 (records 1-4 of 12 total)

// Page 2
from: 5, to: 8 (records 5-8 of 12 total)

// Page 3
from: 9, to: 12 (records 9-12 of 12 total)
```

---

## Rate Limiting

No rate limiting implemented (educational project).

For production deployment, consider:
- IP-based rate limiting
- User-based rate limiting
- Request throttling middleware

---

## Authentication

No authentication required (educational project).

For production deployment, consider:
- User login system
- Role-based access control
- API token authentication

---

## CORS

No CORS restrictions (educational project).

If frontend moves to different domain:
```php
// Add to app/Http/Middleware

protected $except = [
    'api/*',
];
```

---

## Date Handling

**Input Format**: dd-mm-yyyy
**Internal Format**: yyyy-mm-dd (MySQL DATE)
**Output Format**: dd-mm-yyyy (in views)

Conversion handled automatically by controller:
```php
$dateObj = DateTime::createFromFormat('d-m-Y', $input);
$dbFormat = $dateObj->format('Y-m-d');
```

---

## Database Transactions

- Currently no transaction wrapping (reads only)
- For future writes, wrap in transactions:
```php
DB::beginTransaction();
try {
    // INSERT/UPDATE operations
    DB::commit();
} catch (Exception $e) {
    DB::rollback();
}
```

---

## Logging

Basic Laravel logging implemented via:
```php
Log::info('User accessed products overview');
Log::error('Database error', $exception);
```

Logs stored in: `storage/logs/laravel.log`

---

**Version**: 1.0
**Last Updated**: March 2026
**Status**: Complete
