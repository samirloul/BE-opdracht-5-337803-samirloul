# Database Specification - Opdracht 5 User Story 01

## Table Specifications

### 1. Contact
**Purpose**: Stores company contact information for suppliers

| Field | Type | Nullable | Key | Description |
|-------|------|----------|-----|-------------|
| Id | INT | No | PRIMARY | Auto-increment primary key |
| Straat | VARCHAR(100) | No | - | Street name |
| Huisnummer | VARCHAR(10) | No | - | House number (varchar for flexibility) |
| Postcode | VARCHAR(10) | No | - | Dutch postal code |
| Stad | VARCHAR(50) | No | - | City/Municipality |
| IsActief | BIT | No | - | Soft delete flag (1=active, 0=inactive) |
| Opmerking | VARCHAR(250) | Yes | - | Administrative notes |
| DatumAangemaakt | DATETIME(6) | No | - | Audit: Creation timestamp |
| DatumGewijzigd | DATETIME(6) | No | - | Audit: Last modification timestamp |

**Indexes**: None required (used as FK reference)

---

### 2. Leverancier (Supplier)
**Purpose**: Stores supplier master data with contact relationships

| Field | Type | Nullable | Key | Description |
|-------|------|----------|-----|-------------|
| Id | INT | No | PRIMARY | Auto-increment primary key |
| Naam | VARCHAR(100) | No | - | Supplier company name |
| ContactPersoon | VARCHAR(100) | No | - | Primary contact person |
| LeverancierNummer | VARCHAR(20) | No | UNIQUE | Unique supplier code |
| Mobiel | VARCHAR(15) | No | - | Contact phone number |
| ContactId | INT | Yes | FK | Foreign key to Contact.Id |
| IsActief | BIT | No | - | Soft delete flag |
| Opmerking | VARCHAR(250) | Yes | - | Administrative notes |
| DatumAangemaakt | DATETIME(6) | No | - | Audit: Creation timestamp |
| DatumGewijzigd | DATETIME(6) | No | - | Audit: Last modification timestamp |

**Foreign Keys**:
- ContactId → Contact.Id (ON DELETE SET NULL)

**Constraints**:
- LeverancierNummer UNIQUE

---

### 3. Allergeen (Allergen)
**Purpose**: Allergen master list for product classification

| Field | Type | Nullable | Key | Description |
|-------|------|----------|-----|-------------|
| Id | INT | No | PRIMARY | Auto-increment primary key |
| Naam | VARCHAR(50) | No | - | Allergen name (e.g., "Gluten", "Lactose") |
| Omschrijving | VARCHAR(200) | Yes | - | Detailed allergen description |
| IsActief | BIT | No | - | Soft delete flag |
| Opmerking | VARCHAR(250) | Yes | - | Administrative notes |
| DatumAangemaakt | DATETIME(6) | No | - | Audit: Creation timestamp |
| DatumGewijzigd | DATETIME(6) | No | - | Audit: Last modification timestamp |

---

### 4. Product
**Purpose**: Product catalog

| Field | Type | Nullable | Key | Description |
|-------|------|----------|-----|-------------|
| Id | INT | No | PRIMARY | Auto-increment primary key |
| Naam | VARCHAR(100) | No | - | Product name |
| Barcode | VARCHAR(20) | No | UNIQUE | Product barcode (EAN-13 format) |
| IsActief | BIT | No | - | Soft delete flag |
| Opmerking | VARCHAR(250) | Yes | - | Administrative notes |
| DatumAangemaakt | DATETIME(6) | No | - | Audit: Creation timestamp |
| DatumGewijzigd | DATETIME(6) | No | - | Audit: Last modification timestamp |

**Constraints**:
- Barcode UNIQUE

---

### 5. ProductPerAllergeen
**Purpose**: Many-to-many relationship between Products and Allergens

| Field | Type | Nullable | Key | Description |
|-------|------|----------|-----|-------------|
| Id | INT | No | PRIMARY | Auto-increment primary key |
| ProductId | INT | No | FK | Foreign key to Product.Id |
| AllergeenId | INT | No | FK | Foreign key to Allergeen.Id |
| IsActief | BIT | No | - | Soft delete flag |
| Opmerking | VARCHAR(250) | Yes | - | Administrative notes |
| DatumAangemaakt | DATETIME(6) | No | - | Audit: Creation timestamp |
| DatumGewijzigd | DATETIME(6) | No | - | Audit: Last modification timestamp |

**Foreign Keys**:
- ProductId → Product.Id (ON DELETE CASCADE)
- AllergeenId → Allergeen.Id (ON DELETE CASCADE)

**Constraints**:
- UNIQUE KEY (ProductId, AllergeenId) - prevents duplicate allergen linkages

---

### 6. ProductPerLeverancier (Deliveries)
**Purpose**: Tracks product deliveries from suppliers with dates and quantities

| Field | Type | Nullable | Key | Description |
|-------|------|----------|-----|-------------|
| Id | INT | No | PRIMARY | Auto-increment primary key |
| LeverancierId | INT | No | FK | Foreign key to Leverancier.Id |
| ProductId | INT | No | FK | Foreign key to Product.Id |
| DatumLevering | DATE | No | INDEX | Delivery date (used for filtering in Scenario 01) |
| Aantal | INT | No | - | Quantity delivered (in units) |
| DatumEerstVolgendeLevering | DATE | Yes | - | Expected next delivery date |
| IsActief | BIT | No | - | Soft delete flag |
| Opmerking | VARCHAR(250) | Yes | - | Delivery notes (e.g., "damaged units", "partial delivery") |
| DatumAangemaakt | DATETIME(6) | No | - | Audit: Creation timestamp |
| DatumGewijzigd | DATETIME(6) | No | - | Audit: Last modification timestamp |

**Foreign Keys**:
- LeverancierId → Leverancier.Id (ON DELETE CASCADE)
- ProductId → Product.Id (ON DELETE CASCADE)

**Indexes**:
- idx_datum_levering (DatumLevering) - Critical for date range filtering
- idx_product_id (ProductId) - For product lookups
- idx_leverancier_id (LeverancierId) - For supplier analytics

---

### 7. Magazijn (Warehouse/Stock)
**Purpose**: Tracks product inventory levels by packaging

| Field | Type | Nullable | Key | Description |
|-------|------|----------|-----|-------------|
| Id | INT | No | PRIMARY | Auto-increment primary key |
| ProductId | INT | No | FK | Foreign key to Product.Id |
| VerpakkingsEenheid | DECIMAL(5,2) | No | - | Packaging unit (e.g., 0.5 kg, 1.5 L) |
| AantalAanwezig | INT | Yes | - | Current stock quantity of this package size |
| IsActief | BIT | No | - | Soft delete flag |
| Opmerking | VARCHAR(250) | Yes | - | Stock notes |
| DatumAangemaakt | DATETIME(6) | No | - | Audit: Creation timestamp |
| DatumGewijzigd | DATETIME(6) | No | - | Audit: Last modification timestamp |

**Foreign Keys**:
- ProductId → Product.Id (ON DELETE CASCADE)

**Constraints**:
- UNIQUE KEY (ProductId, VerpakkingsEenheid) - each product/package combo once

---

## System Fields (Present on All Tables)

| Field | Type | Purpose |
|-------|------|---------|
| IsActief | BIT | Soft delete - allows data retention without physical deletion |
| Opmerking | VARCHAR(250) | Free-form administrative comments |
| DatumAangemaakt | DATETIME(6) | Audit trail - row creation timestamp |
| DatumGewijzigd | DATETIME(6) | Audit trail - last modification timestamp |

---

## Relationships Diagram

```
Contact (1) ──→ (N) Leverancier
                       │
                       └──→ (N) ProductPerLeverancier ←── (1) Product
                                                              │
                                                              ├──→ (N) ProductPerAllergeen ←── (1) Allergeen
                                                              └──→ (N) Magazijn
```

---

## Data Integrity Rules

1. **Cascade Deletes**: 
   - Deleting a Product cascades to ProductPerAllergeen, ProductPerLeverancier, Magazijn
   - Deleting a Leverancier cascades to ProductPerLeverancier
   - Deleting an Allergeen cascades to ProductPerAllergeen

2. **Set Null on Delete**: 
   - Deleting a Contact sets ContactId to NULL in Leverancier (allows for orphaned suppliers)

3. **Unique Constraints**:
   - LeverancierNummer (Leverancier) - supplier codes must be unique
   - Barcode (Product) - product barcodes must be unique
   - ProductId + AllergeenId (ProductPerAllergeen) - prevent duplicate allergen links
   - ProductId + VerpakkingsEenheid (Magazijn) - prevent duplicate stock entries

4. **Soft Deletes**:
   - All tables support IsActief flag for reversible deletion
   - No hard deletes recommended due to audit trail requirements

---

## Test Data

The seeder (opdracht5Seeder.php) provides:
- 6 Contacts (company addresses)
- 7 Leveranciers (Jamin suppliers: Venco, Astra Sweets, Haribo, Basset, De Bron, Quality Street, Hom Ken Food)
- 5 Allergeens (Gluten, Gelatine, AZO-Kleurstof, Lactose, Soja)
- 14 Products (different candy/sweets products)
- 13 ProductPerAllergeen links
- 18 ProductPerLeverancier deliveries (April 2023, with test case for 08-04-2023 to 19-04-2023)
- 13 Magazijn stock entries

---

## SQL Queries for Common Operations

### Get products delivered in date range
```sql
CALL GetProductsByDateRange('2023-04-08', '2023-04-19');
```

### Get delivery details for a product
```sql
CALL GetProductSpecification(3, '2023-04-08', '2023-04-19');
```

### Get allergens for a product
```sql
CALL GetAllergensForProduct(3);
```

### Verify deliveries exist in date range
```sql
CALL GetProductsWithoutLeveringen('2025-01-01', '2025-12-31');
```

---

## Database Indexing Strategy

- `DatumLevering` indexed for fast date-range filtering (Scenario 01)
- `ProductId` indexed for quick product lookups (Scenario 02)
- `LeverancierId` indexed for supplier-based analytics
- Foreign key columns naturally indexed in MySQL

---

**Last Updated**: March 2026
**Version**: 1.0
**Status**: Production Ready
