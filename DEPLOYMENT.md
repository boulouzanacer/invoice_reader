## Deploying (Laravel 9 / PHP 8.0)

### Prerequisites
- PHP >= 8.0.2 with extensions: OpenSSL, PDO_MySQL, Mbstring, Tokenizer, XML, Ctype, JSON, Fileinfo
- Composer
- MySQL/MariaDB database
- A web server (Apache/Nginx) pointing the document root to `public/`

### 1) Upload the project
Preferred options:
- Git clone on the server (best), or
- Upload a ZIP and extract on the server

Make sure `vendor/` is not uploaded from local. Install it on the server with Composer.

### 2) Install dependencies
From the project root:
```bash
composer install --no-dev --optimize-autoloader
```

### 3) Environment configuration
Copy `.env.example` to `.env` on the server and set:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.tld`
- DB credentials (`DB_*`)

Generate application key:
```bash
php artisan key:generate
```

### 4) Storage permissions
Ensure these are writable by the web server user:
- `storage/`
- `bootstrap/cache/`

### 5) Database migrations
```bash
php artisan migrate --force
```

### 6) Create an admin user
If you have SSH access:
```bash
php artisan user:create-admin --email="admin@your-domain.tld" --password="your-password" --name="Admin"
```

### 7) Cache optimizations (recommended)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8) Web server document root
Your domain/subdomain document root must be:
- `<project>/public`

If you are on shared hosting where the document root is fixed to `public_html/`, use one of these approaches:
- Set the domain document root to the Laravel `public/` folder (preferred), or
- Put the contents of `public/` into `public_html/` and change `index.php` paths accordingly (less ideal).

