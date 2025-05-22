# Ecommerce Saas Application

## Requirements
- PHP >= 8.2
- Composer >= 2.x
- MySQL or MariaDB
- Node.js & NPM (or Yarn)
- A local development server (e.g., Laravel Valet, XAMPP, Laravel Sail, etc.)

## Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/RakibulIslamm/E-Commerce.git
   cd E-Commerce
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```
3. **Install Node dependencies**

   ```bash
   npm install
   ```

4. **Copy and configure your .env file**

   ```bash
   cp .env.example .env
   ```

Then update the .env file with your environment settings. Here's a sample based on your configuration:
  ```bash
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:r7jKB4HvYyEWP+pV/66ptf872KYjZLtVcTAsQtBTKb8=
    APP_DEBUG=true
    APP_TIMEZONE=UTC
    APP_URL=http://example.com

    APP_LOCALE=en
    APP_FALLBACK_LOCALE=en
    APP_FAKER_LOCALE=en_US

    APP_MAINTENANCE_DRIVER=file
    APP_MAINTENANCE_STORE=database
    ASSET_URL_TENANT=example.com
    BCRYPT_ROUNDS=12

    CENTRAL_DOMAIN=example.com

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=db_root_user
    DB_PASSWORD=*****

    # PLESK
    PLESK_BASE_URL="pleask_api_url"
    PLESK_USERNAME="admin"
    PLESK_PASSWORD="password"

  ```

5. **Generate the application key**

   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**

   ```bash
   php artisan migrate
   ```


**🌐 Run the Application**
  ```bash
   php artisan serve
  ```

**⚙️ Frontend Assets**
   ```bash
    npm run dev
   ```


## Steps for Each Instance (Plesk)

1. **Buy or Transfer the Domain**  
   Purchase a new domain or transfer an existing one to your preferred registrar.

2. **Set Up Domain Alias in Plesk**  
   Add the domain as an alias under your main hosting account in the Plesk control panel.

3. **Add SSL Certificate via DNS TXT Record**  
   To enable SSL (Let's Encrypt), add a DNS TXT record for domain verification.

   - Use the DNS zone of the **main host domain**: `asefecommerce.space`
   - Add the following TXT record format:

    ### Example TXT Record
    Domain name: acme-challenge.asefecommerce.space
    Record value: odqUG3qVb8HzmyZTo9TMEcQOYU

