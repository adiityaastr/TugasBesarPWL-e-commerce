# Panduan Instalasi dan Deployment Herbamart E-Commerce

## 1. Pendahuluan

Dokumen ini menjelaskan langkah-langkah lengkap untuk menginstal dan mendeploy aplikasi Herbamart E-Commerce, mulai dari development environment hingga production deployment.

## 2. Prasyarat

### 2.1 Software Requirements

**Minimum Requirements:**
- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 18.x
- NPM >= 9.x
- Database Server (MySQL 8.0+ / PostgreSQL 13+ / SQLite 3.8+)

**Recommended:**
- PHP 8.3
- Composer 2.6+
- Node.js 20.x LTS
- MySQL 8.0 atau PostgreSQL 15
- Git

### 2.2 Server Requirements

**Development:**
- RAM: 2GB minimum
- Storage: 1GB free space
- OS: Linux, macOS, atau Windows (dengan WSL)

**Production:**
- RAM: 4GB minimum (8GB recommended)
- Storage: 10GB+ free space
- OS: Linux (Ubuntu 22.04 LTS recommended)
- Web Server: Nginx atau Apache
- PHP-FPM

## 3. Instalasi Development Environment

### 3.1 Clone Repository

```bash
git clone https://github.com/username/TugasBesarPWL-e-commerce.git
cd TugasBesarPWL-e-commerce
```

### 3.2 Install PHP Dependencies

```bash
composer install
```

**Catatan**: Jika menggunakan PHP 8.2+, pastikan semua extension yang diperlukan sudah terinstall:
- `php-mbstring`
- `php-xml`
- `php-curl`
- `php-zip`
- `php-gd`
- `php-mysql` atau `php-pgsql`

### 3.3 Install Node.js Dependencies

```bash
npm install
```

### 3.4 Setup Environment File

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi:

```env
APP_NAME="Herbamart"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=herbamart
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3.5 Generate Application Key

```bash
php artisan key:generate
```

### 3.6 Setup Database

**MySQL:**

```bash
mysql -u root -p
CREATE DATABASE herbamart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

**PostgreSQL:**

```bash
psql -U postgres
CREATE DATABASE herbamart;
\q
```

**SQLite:**

```bash
touch database/database.sqlite
```

Update `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### 3.7 Run Migrations

```bash
php artisan migrate
```

### 3.8 Seed Database

```bash
php artisan db:seed
```

**Default Accounts:**
- **Admin**: `admin@example.com` / `password`
- **Customer**: `user@example.com` / `password`

### 3.9 Create Storage Link

```bash
php artisan storage:link
```

Ini akan membuat symbolic link dari `storage/app/public` ke `public/storage` untuk akses file upload.

### 3.10 Build Frontend Assets

**Development Mode:**

```bash
npm run dev
```

Biarkan terminal ini tetap berjalan untuk hot-reload.

**Production Build:**

```bash
npm run build
```

### 3.11 Start Development Server

**Terminal baru:**

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

## 4. Konfigurasi Tambahan

### 4.1 Setup Scheduler (Auto-Complete Order)

Untuk fitur auto-complete order setelah 3 hari, setup cron job:

```bash
crontab -e
```

Tambahkan:

```cron
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

**Atau** untuk development, jalankan secara manual:

```bash
php artisan schedule:work
```

### 4.2 Setup Queue Worker (Jika Menggunakan Queue)

```bash
php artisan queue:work
```

### 4.3 Setup Mail Configuration

Untuk production, konfigurasi SMTP di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@herbamart.com
MAIL_FROM_NAME="Herbamart"
```

## 5. Production Deployment

### 5.1 Server Setup

**Update System:**

```bash
sudo apt update
sudo apt upgrade -y
```

**Install PHP dan Extensions:**

```bash
sudo apt install php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd
```

**Install Composer:**

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**Install Node.js:**

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs
```

**Install Nginx:**

```bash
sudo apt install nginx
```

**Install MySQL:**

```bash
sudo apt install mysql-server
sudo mysql_secure_installation
```

### 5.2 Deploy Application

**Clone Repository:**

```bash
cd /var/www
sudo git clone https://github.com/username/TugasBesarPWL-e-commerce.git
sudo chown -R www-data:www-data TugasBesarPWL-e-commerce
cd TugasBesarPWL-e-commerce
```

**Install Dependencies:**

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

**Setup Environment:**

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` untuk production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=herbamart
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

**Run Migrations:**

```bash
php artisan migrate --force
```

**Setup Storage:**

```bash
php artisan storage:link
sudo chown -R www-data:www-data storage bootstrap/cache
```

**Optimize Application:**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5.3 Nginx Configuration

Buat file konfigurasi Nginx:

```bash
sudo nano /etc/nginx/sites-available/herbamart
```

Isi dengan:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/TugasBesarPWL-e-commerce/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/herbamart /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 5.4 SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

### 5.5 Setup Supervisor (Queue Worker)

Buat file supervisor config:

```bash
sudo nano /etc/supervisor/conf.d/herbamart-worker.conf
```

Isi dengan:

```ini
[program:herbamart-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/TugasBesarPWL-e-commerce/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/TugasBesarPWL-e-commerce/storage/logs/worker.log
stopwaitsecs=3600
```

Reload supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start herbamart-worker:*
```

### 5.6 Setup Cron Job

```bash
sudo crontab -e -u www-data
```

Tambahkan:

```cron
* * * * * cd /var/www/TugasBesarPWL-e-commerce && php artisan schedule:run >> /dev/null 2>&1
```

## 6. Troubleshooting

### 6.1 Permission Issues

```bash
sudo chown -R www-data:www-data /var/www/TugasBesarPWL-e-commerce
sudo chmod -R 755 /var/www/TugasBesarPWL-e-commerce
sudo chmod -R 775 /var/www/TugasBesarPWL-e-commerce/storage
sudo chmod -R 775 /var/www/TugasBesarPWL-e-commerce/bootstrap/cache
```

### 6.2 Storage Link Issues

```bash
php artisan storage:link
# Jika error, hapus link yang ada dulu
rm public/storage
php artisan storage:link
```

### 6.3 Database Connection Issues

- Cek kredensial di `.env`
- Cek database sudah dibuat
- Cek user database memiliki permission
- Cek firewall/port MySQL

### 6.4 500 Error

- Cek log: `storage/logs/laravel.log`
- Cek permission storage dan cache
- Clear cache: `php artisan cache:clear`
- Cek `.env` configuration

### 6.5 Assets Tidak Muncul

- Pastikan `npm run build` sudah dijalankan
- Cek `public/build` folder ada
- Clear browser cache
- Cek `APP_URL` di `.env` sudah benar

## 7. Backup dan Restore

### 7.1 Database Backup

```bash
mysqldump -u root -p herbamart > backup_$(date +%Y%m%d).sql
```

### 7.2 Database Restore

```bash
mysql -u root -p herbamart < backup_20241201.sql
```

### 7.3 File Backup

```bash
tar -czf herbamart_backup_$(date +%Y%m%d).tar.gz /var/www/TugasBesarPWL-e-commerce
```

## 8. Update Application

### 8.1 Update Code

```bash
cd /var/www/TugasBesarPWL-e-commerce
git pull origin main
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8.2 Rollback

```bash
git checkout <previous-commit>
composer install --optimize-autoloader --no-dev
php artisan migrate:rollback
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 9. Monitoring

### 9.1 Log Files

- Application logs: `storage/logs/laravel.log`
- Nginx logs: `/var/log/nginx/`
- PHP-FPM logs: `/var/log/php8.2-fpm.log`

### 9.2 Health Check

Laravel menyediakan health check endpoint:

```
GET /up
```

### 9.3 Performance Monitoring

Pertimbangkan untuk menggunakan:
- Laravel Telescope (development)
- Laravel Debugbar (development)
- Application Performance Monitoring (APM) tools untuk production

## 10. Security Checklist

- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production` di production
- [ ] Strong database password
- [ ] SSL certificate installed
- [ ] Firewall configured
- [ ] Regular security updates
- [ ] Backup strategy implemented
- [ ] File permissions set correctly
- [ ] `.env` file tidak di-commit ke git
- [ ] CSRF protection enabled
- [ ] SQL injection prevention (Eloquent ORM)
- [ ] XSS protection (Blade auto-escaping)

---

**Catatan**: Dokumentasi ini mencakup setup dasar. Untuk production dengan traffic tinggi, pertimbangkan untuk menggunakan load balancer, database replication, CDN, dan caching layer (Redis/Memcached).
