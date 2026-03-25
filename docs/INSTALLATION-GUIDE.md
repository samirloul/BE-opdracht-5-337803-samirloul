# Installation Guide - Opdracht 5 User Story 01

## Overview

This guide walks through the complete setup process for running the Opdracht 5 application locally and on production servers.

## System Requirements

### Minimum Requirements
- **PHP**: 8.4 or higher
- **MySQL**: 8.0 or higher
- **Composer**: 2.2 or higher
- **Node.js**: 18+ (optional, for asset compilation)
- **Disk Space**: 500 MB minimum
- **RAM**: 1 GB minimum

### Recommended Requirements
- **PHP**: 8.4 (latest stable)
- **MySQL**: 8.0.33+
- **Composer**: Latest version
- **Node.js**: 18 LTS
- **Disk Space**: 1 GB
- **RAM**: 2 GB

### Operating Systems
- Windows (7+, with WSL2 recommended for development)
- macOS (10.12+)
- Linux (Ubuntu 18.04+, CentOS 7+)

## Pre-Installation Steps

### 1. Install PHP 8.4

**Windows (XAMPP/Laragon)**:
```powershell
# Download from https://www.apachefriends.org/ or https://laragon.org/
# Extract and run installer
# Verify: php --version
```

**macOS (Homebrew)**:
```bash
brew install php@8.4
php --version
```

**Linux (Ubuntu)**:
```bash
sudo apt update
sudo apt install php8.4 php8.4-mysql php8.4-curl php8.4-xml php8.4-zip
php --version
```

### 2. Install MySQL 8.0

**Windows (MySQL Installer)**:
```powershell
# Download from https://dev.mysql.com/downloads/installer/
# Run installer and follow prompts
# Verify: mysql --version
```

**macOS (Homebrew)**:
```bash
brew install mysql@8.0
mysql.server start
mysql --version
```

**Linux (Ubuntu)**:
```bash
sudo apt install mysql-server
sudo mysql_secure_installation
mysql --version
```

### 3. Install Composer

**All Platforms**:
```bash
# Download from https://getcomposer.org/download/
# Or for macOS/Linux:
curl -sS https://getinstaller.packagist.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### 4. Install Git

**Windows**:
```powershell
# Download from https://git-scm.com/download/win
# Or: choco install git
```

**macOS**:
```bash
brew install git
```

**Linux (Ubuntu)**:
```bash
sudo apt install git
```

## Project Installation

### Step 1: Clone Repository

```bash
# SSH (recommended)
git clone git@github.com:username/BE-opdracht-5-P3-studentnummer.git opdracht5

# HTTPS
git clone https://github.com/username/BE-opdracht-5-P3-studentnummer.git opdracht5

cd opdracht5
```

### Step 2: Checkout Development Branch

```bash
git checkout dev-opdracht-5-us01
```

### Step 3: Install PHP Dependencies

```bash
composer install
```

**Expected output**:
```
Installing dependencies from lock file
Loading composer repositories with package definitions
Updating dependencies
... [various packages]
Successfully installed ...
```

### Step 4: Create Environment File

```bash
# Copy example environment
cp .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env
```

### Step 5: Configure Database Connection

Edit `.env` file:

```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opdracht5
DB_USERNAME=root
DB_PASSWORD=  # Leave empty if no password set
```

**Windows XAMPP Users**:
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=opdracht5
DB_USERNAME=root
DB_PASSWORD=
```

**macOS/Linux Users**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opdracht5
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Step 6: Generate Application Key

```bash
php artisan key:generate
```

**Output**: `Application key set successfully.`

### Step 7: Create Database

**Via MySQL Client**:
```bash
mysql -u root -p

# In MySQL shell:
CREATE DATABASE opdracht5;
EXIT;
```

**Via Terminal (if password is empty)**:
```bash
mysql -u root -e "CREATE DATABASE opdracht5;"
```

### Step 8: Run Database Migrations

```bash
php artisan migrate
```

**Expected output**:
```
  2026_03_25_133156_create_contacts_table
  2026_03_25_133157_create_products_table
  2026_03_25_133157_create_leveranciers_table
... [all 7 migrations]
```

If migration fails, check:
- MySQL is running
- Database connection in `.env` is correct
- Database `opdracht5` exists

### Step 9: Seed Test Data

```bash
php artisan db:seed --class=opdracht5Seeder
```

**Expected output**:
```
Seeding: opdracht5Seeder
... [records being inserted]
Finished seeding
```

This populates:
- 6 Contacts
- 7 Leveranciers
- 5 Allergeens
- 14 Products
- 13 ProductPerAllergeen links
- 18 ProductPerLeverancier deliveries
- 13 Magazijn entries

### Step 10: Verify Installation

```bash
# Run tests
php artisan test

# Expected: All tests pass (5+ tests)
Tests:  5 passed
```

### Step 11: Start Development Server

```bash
php artisan serve
```

**Output**:
```
   INFO  Server running on [http://127.0.0.1:8000]
```

### Step 12: Access Application

Open browser and navigate to:
```
http://127.0.0.1:8000
```

You should see the homepage with "Ga naar Overzicht Geleverde Producten" button.

---

## Post-Installation Verification

### Test All Scenarios

**Scenario 01**: Product Overview
```
1. Navigate to /producten
2. Leave date fields empty
3. See all products (4 per page)
4. Click "Maak Selectie" without dates
5. See full product list
```

**Scenario 02**: Product Specification
```
1. From overview, click "?" on any product
2. See product details, allergens, and deliveries
3. Verify delivery dates and quantities display
```

**Scenario 03**: No Results
```
1. Go to /producten
2. Enter: Start: 01-05-2025, End: 31-05-2025
3. Click "Maak Selectie"
4. See: "Er zijn geen leveringen geweest van producten in deze periode"
```

**Test Case (Real Data Included)**:
```
Start Date: 08-04-2023
End Date: 19-04-2023
Expected: Products with deliveries in this period
```

---

## Troubleshooting

### Error: `SQLSTATE[HY000]: General error: 1030 Got error...`
**Solution**:
```bash
# Increase MySQL max_allowed_packet
mysql -u root -p -e "SET GLOBAL max_allowed_packet=67108864;"
```

### Error: `Class 'PDO' not found`
**Solution**: Install PHP MySQL extension
```bash
# macOS
brew install php@8.4-mysql

# Ubuntu
sudo apt install php8.4-mysql

# Windows: Download and place in php/ext/ directory
```

### Error: `Symfony\Component\Process\Exception\ProcessTimedOutException`
**Solution**:
```bash
# Increase timeout for long operations
php artisan migrate --timeout=600
```

### Error: `Unable to open file for writing`
**Solution**: Fix file permissions
```bash
# macOS/Linux
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Windows (via PowerShell as Admin)
Get-ChildItem storage/, bootstrap/cache/ | ForEach-Object { attrib +R -H $_ }
```

### Error: `Connection refused` (MySQL)
**Solution**: Verify MySQL is running
```bash
# Check MySQL status
mysql.server status  # macOS
sudo systemctl status mysql  # Linux
# Windows: Check Services (services.msc)

# Restart MySQL if needed
mysql.server restart  # macOS
sudo systemctl restart mysql  # Linux
```

### Error: Database already exists
**Solution**:
```bash
mysql -u root -p -e "DROP DATABASE IF EXISTS opdracht5;"
php artisan migrate  # Re-run migrations
```

---

## Development Setup (Optional)

### Install Node Dependencies (for asset compilation)

```bash
npm install
npm run dev
```

### IDE Configuration (VS Code)

Create `.vscode/settings.json`:
```json
{
    "php.validate.executablePath": "/usr/bin/php",
    "php.validate.run": "onSave",
    "editor.formatOnSave": true,
    "[php]": {
        "editor.defaultFormatter": "junstyle.php-cs-fixer",
        "editor.formatOnSave": true
    }
}
```

### Install PHP Debugging Extension

```bash
# macOS
brew install php-xdebug

# Update php.ini with:
zend_extension="xdebug.so"
xdebug.mode = develop,debug
xdebug.start_with_request = yes
```

---

## Production Deployment

### Prerequisites
- Linux server (Ubuntu 20.04+)
- SSH access
- Dedicated domain

### Deployment Steps

```bash
# 1. SSH into server
ssh user@server.com

# 2. Install dependencies
sudo apt update
sudo apt install php8.4 mysql-server nginx composer

# 3. Clone repository
git clone -b dev-opdracht-5-us01 https://github.com/username/repo.git /var/www/opdracht5

# 4. Configure web server (Nginx)
sudo nano /etc/nginx/sites-enabled/opdracht5
# Add server block configuration

# 5. Set permissions
sudo chown -R www-data:www-data /var/www/opdracht5
sudo chmod -R 755 /var/www/opdracht5/storage

# 6. Install composer dependencies
cd /var/www/opdracht5
composer install --no-dev

# 7. Configure .env
cp .env.example .env
nano .env  # Set production values

# 8. Generate app key
php artisan key:generate

# 9. Run migrations (production database)
php artisan migrate --force

# 10. Seed database
php artisan db:seed --class=opdracht5Seeder

# 11. Cache configuration
php artisan config:cache
php artisan route:cache

# 12. Restart web server
sudo systemctl restart nginx
```

### SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot certonly --nginx -d yourdomain.com
```

---

## Maintenance

### Regular Backups

```bash
# Database backup
mysqldump -u root -p opdracht5 > backup_$(date +%Y%m%d).sql

# Full project backup
tar -czf opdracht5_$(date +%Y%m%d).tar.gz /var/www/opdracht5
```

### Update Dependencies

```bash
# Check for updates
composer update --dry-run

# Install updates
composer update
```

### Clear Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## Uninstallation

```bash
# Remove project directory
rm -rf opdracht5/

# Drop database
mysql -u root -p -e "DROP DATABASE opdracht5;"
```

---

**Version**: 1.0
**Last Updated**: March 2026
**Support**: Contact instructors or check GitHub issues
