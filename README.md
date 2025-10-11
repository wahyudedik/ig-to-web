# 🏫 School Management System - Complete Digital Solution

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-Commercial-green.svg)](https://envato.com)
[![Made with ❤️](https://img.shields.io/badge/Made%20with-❤️-red.svg)](https://github.com)

> **Professional School Management System with Role-Based Access Control, Instagram Integration, E-Voting, Real-time Notifications, and Complete Administrative Modules**

**✨ Powered by Wahyu Code** - *Building Excellence, One Line at a Time* 💻

---

## 🌟 **Features Overview**

### 🎯 **Core Features**
- **🔐 Role-Based Access Control** - Superadmin, Admin, Guru, Siswa, Sarpras
- **🔔 Real-time Notification System** - Dropdown notifications with unread badge
- **📱 Instagram Integration** - Auto-sync with school Instagram account
- **🗳️ E-OSIS Voting System** - Digital student council elections with real-time results
- **🎓 E-Lulus Graduation System** - Digital graduation announcements with certificate generation
- **🏢 Sarpras Management** - Complete facilities & infrastructure management with barcode
- **📄 Page Management** - WYSIWYG content management with SEO optimization
- **📊 Analytics Dashboard** - Real-time statistics, charts, and comprehensive reports
- **🔍 System Health Monitor** - Database, cache, storage, and performance monitoring
- **📧 Email Verification** - Secure email verification for new users
- **🔒 Security Features** - CSRF protection, input validation, SQL injection prevention

### 🎨 **Frontend Features**
- **🎨 Modern UI/UX** - Beautiful Tailwind CSS design with Alpine.js
- **📱 Fully Responsive** - Mobile-first responsive design for all devices
- **⚡ Fast Loading** - Optimized performance with server-side rendering
- **🎯 User-Friendly** - Intuitive interface with dropdown menus and modals
- **🔍 SEO Optimized** - Built-in SEO features and meta tags
- **💫 Smooth Animations** - Alpine.js transitions and hover effects
- **🌈 Custom Components** - Reusable Blade components

### 🔧 **Technical Features**
- **🏗️ Laravel 12.x** - Latest Laravel framework with PHP 8.4
- **🔐 Spatie Laravel Permission** - Advanced role and permission system
- **📊 Excel Import/Export** - Bulk data management with Maatwebsite/Excel
- **🏷️ Barcode System** - Asset tracking with barcode generation
- **📈 Real-time Notifications** - Database-driven notification system
- **🛡️ Security First** - CSRF protection, validation, and sanitization
- **🗄️ Pure Monolith Architecture** - Server-side rendering for better performance
- **🎨 Tailwind CSS** - Utility-first CSS framework
- **⚡ Alpine.js** - Lightweight JavaScript framework

---

## 🚀 **Quick Start - Local Development**

### **Requirements**
- PHP 8.2 or higher
- Composer 2.x
- MySQL 8.0+ or MariaDB 10.3+
- Node.js 18+ & NPM
- Git

### **Installation for Local Development**

#### **Step 1: Clone Repository**
```bash
# Clone the repository
git clone https://github.com/your-repo/school-management-system.git
cd school-management-system

# Or if you have the zip file
unzip school-management-system.zip
cd school-management-system
```

#### **Step 2: Install PHP Dependencies**
```bash
composer install
```

#### **Step 3: Environment Configuration**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### **Step 4: Database Setup**
```bash
# Create database (MySQL)
mysql -u root -p
CREATE DATABASE sekolah_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Run migrations
php artisan migrate

# Seed initial data (roles, permissions, sample data)
php artisan db:seed

# Create notifications table
php artisan migrate
```

#### **Step 5: Storage & Cache Setup**
```bash
# Create storage symlink
php artisan storage:link

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for development
php artisan optimize:clear
```

#### **Step 6: Install Frontend Dependencies**
```bash
# Install Node packages
npm install

# Build assets for development
npm run dev

# Or watch for changes
npm run watch
```

#### **Step 7: Start Development Server**
```bash
# Start Laravel development server
php artisan serve

# Access the application at:
# http://localhost:8000
```

#### **Default Login Credentials**
After seeding, you can login with:
- **Superadmin:**
  - Email: `superadmin@sekolah.com`
  - Password: `password`
- **Admin:**
  - Email: `admin@sekolah.com`
  - Password: `password`

---

## 🚀 **Production Deployment - Ubuntu VPS**

### **Server Requirements**
- **Ubuntu 20.04 LTS or 22.04 LTS**
- **PHP 8.2+** with extensions
- **MySQL 8.0+** or **MariaDB 10.3+**
- **Nginx** or **Apache**
- **Node.js 18+**
- **Composer 2.x**
- **Git**
- **Minimum 2GB RAM**
- **20GB Storage**

### **Step-by-Step VPS Deployment**

#### **1. Connect to Your VPS**
```bash
ssh root@your-server-ip
# Or
ssh username@your-server-ip
```

#### **2. Update System Packages**
```bash
sudo apt update && sudo apt upgrade -y
```

#### **3. Install PHP 8.2 and Extensions**
```bash
# Add PHP repository
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.2 and required extensions
sudo apt install php8.2 php8.2-fpm php8.2-cli php8.2-common php8.2-mysql \
php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath \
php8.2-intl php8.2-redis php8.2-opcache -y

# Verify PHP installation
php -v
```

#### **4. Install MySQL**
```bash
# Install MySQL Server
sudo apt install mysql-server -y

# Secure MySQL installation
sudo mysql_secure_installation

# Login to MySQL and create database
sudo mysql -u root -p

# In MySQL console:
CREATE DATABASE sekolah_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'sekolah_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON sekolah_db.* TO 'sekolah_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### **5. Install Composer**
```bash
# Download and install Composer
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Verify installation
composer -V
```

#### **6. Install Node.js and NPM**
```bash
# Install Node.js 18.x
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Verify installation
node -v
npm -v
```

#### **7. Install Nginx**
```bash
# Install Nginx
sudo apt install nginx -y

# Start and enable Nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# Check status
sudo systemctl status nginx
```

#### **8. Clone and Setup Application**
```bash
# Navigate to web directory
cd /var/www

# Clone repository (or upload files via FTP/SCP)
sudo git clone https://github.com/your-repo/school-management-system.git sekolah
cd sekolah

# Set ownership
sudo chown -R www-data:www-data /var/www/sekolah
sudo chmod -R 755 /var/www/sekolah
sudo chmod -R 775 /var/www/sekolah/storage
sudo chmod -R 775 /var/www/sekolah/bootstrap/cache
```

#### **9. Install Application Dependencies**
```bash
# Install Composer dependencies
sudo -u www-data composer install --no-dev --optimize-autoloader

# Copy and configure environment
sudo cp .env.example .env
sudo nano .env

# Configure these values in .env:
APP_NAME="School Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_db
DB_USERNAME=sekolah_user
DB_PASSWORD=your_strong_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Generate application key
sudo -u www-data php artisan key:generate

# Run migrations and seeders
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan db:seed --force

# Create storage symlink
sudo -u www-data php artisan storage:link
```

#### **10. Build Frontend Assets**
```bash
# Install NPM dependencies
npm install

# Build for production
npm run build

# Clean up node_modules (optional, to save space)
rm -rf node_modules
```

#### **11. Optimize Application**
```bash
# Cache configuration
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Optimize composer autoloader
sudo -u www-data composer dump-autoload --optimize
```

#### **12. Configure Nginx**
```bash
# Create Nginx configuration
sudo nano /etc/nginx/sites-available/sekolah

# Add this configuration:
```

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/sekolah/public;

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

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/sekolah /etc/nginx/sites-enabled/

# Remove default site
sudo rm /etc/nginx/sites-enabled/default

# Test Nginx configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

#### **13. Install SSL Certificate (Let's Encrypt)**
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Obtain SSL certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Test auto-renewal
sudo certbot renew --dry-run
```

#### **14. Setup Cron Jobs**
```bash
# Edit crontab
sudo crontab -e -u www-data

# Add Laravel scheduler
* * * * * cd /var/www/sekolah && php artisan schedule:run >> /dev/null 2>&1
```

#### **15. Configure Firewall**
```bash
# Allow Nginx
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable

# Check status
sudo ufw status
```

#### **16. Setup Process Manager (Optional but Recommended)**
```bash
# Install Supervisor for queue workers
sudo apt install supervisor -y

# Create supervisor configuration
sudo nano /etc/supervisor/conf.d/sekolah-worker.conf

# Add this:
[program:sekolah-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/sekolah/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/sekolah/storage/logs/worker.log
stopwaitsecs=3600

# Reload supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start sekolah-worker:*
```

#### **17. Monitoring and Logs**
```bash
# View Laravel logs
sudo tail -f /var/www/sekolah/storage/logs/laravel.log

# View Nginx logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log

# View PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### **Post-Deployment Checklist**

✅ **Security Checklist:**
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set strong `APP_KEY`
- [ ] Use strong database passwords
- [ ] Configure firewall (UFW)
- [ ] Install SSL certificate
- [ ] Set proper file permissions
- [ ] Enable OPcache for PHP
- [ ] Configure fail2ban (optional)
- [ ] Regular backups setup

✅ **Performance Checklist:**
- [ ] Enable Redis for caching (optional)
- [ ] Enable OPcache
- [ ] Optimize database queries
- [ ] Enable gzip compression in Nginx
- [ ] Configure CDN for static assets (optional)

✅ **Maintenance Checklist:**
- [ ] Setup automated backups
- [ ] Configure monitoring (optional: New Relic, Sentry)
- [ ] Setup log rotation
- [ ] Document deployment process
- [ ] Test email functionality
- [ ] Test all features in production

---

## 🏗️ **System Architecture**

### **Route Structure**
```
/                           → Landing Page (Customizable)
/check-graduation          → Public graduation check
/instagram                 → Public Instagram gallery
/kegiatan                  → Alternative Instagram URL

Admin Panel (Authenticated):
/admin                     → Role-based dashboard
/admin/analytics          → Analytics dashboard
/admin/system/health      → System health monitor
/admin/notifications      → Notification center

Superadmin Routes:
/admin/superadmin/*       → Superadmin management
/admin/user-management/*  → User CRUD operations
/admin/role-permissions/* → Role & permission management

Module Routes:
/admin/guru/*             → Teacher management
/admin/siswa/*            → Student management
/admin/osis/*             → E-OSIS voting system
/admin/lulus/*            → E-Lulus graduation
/admin/sarpras/*          → Facilities management
/admin/pages/*            → Page content management
/admin/instagram/*        → Instagram integration
/admin/settings/*         → System settings
```

### **Database Architecture**
- **UUID Primary Keys** - All models use UUID for enhanced security
- **Role-Based Permissions** - Granular access control with Spatie
- **Audit Logging** - Complete activity tracking in `audit_logs` table
- **Soft Deletes** - Data integrity and recovery capability
- **Foreign Key Constraints** - Referential integrity enforcement
- **Notification System** - Database-driven notifications

---

## 👥 **User Roles & Permissions**

### **🔑 Superadmin**
- Full system access and control
- User management (CRUD operations)
- Role & permission assignment
- System configuration and settings
- All module access without restrictions
- Analytics and system health monitoring
- Notification management

### **👨‍💼 Admin**
- Module-specific access (assigned by Superadmin)
- Limited user management capabilities
- Module settings configuration
- Reports and analytics access
- Content management (Pages)
- Student and teacher data management

### **👨‍🏫 Guru (Teacher)**
- Student data viewing and management
- E-OSIS voting participation
- Personal profile management
- Academic records access
- Subject and class management

### **🎓 Siswa (Student)**
- Personal profile management
- E-OSIS voting rights
- E-Lulus access for Grade 12
- Academic records viewing
- Notification access

### **🏢 Sarpras (Facilities Manager)**
- Complete asset management
- Barcode generation and scanning
- Maintenance tracking and scheduling
- Inventory reports
- Room and category management

---

## 📱 **Module Deep Dive**

### **🎓 Student Management**
- **Features:**
  - Complete student profiles with photos
  - Academic records and history
  - Class and department assignments
  - Import/Export via Excel templates
  - Bulk operations support
  - Search and filter capabilities
  - Audit trail for all changes

### **👨‍🏫 Teacher Management**
- **Features:**
  - Comprehensive teacher profiles
  - Multiple subject assignments
  - NIP/NUPTK management
  - Photo and document uploads
  - Excel import/export
- Performance tracking
  - Subject-teacher relationships

### **🗳️ E-OSIS Voting System**
- **Features:**
  - Digital candidate registration
  - Voter list management (auto-sync with users)
  - Gender-based voting rules (putra/putri)
  - Real-time vote counting
  - Results dashboard with charts
  - Teacher view for monitoring
  - Vote analytics and statistics
  - Secure one-time voting
  - Excel import/export for bulk operations

### **🎓 E-Lulus Graduation**
- **Features:**
  - Public graduation status check
- NISN/NIS verification
  - Digital certificate generation (PDF)
  - Bulk import via Excel
  - Status management (lulus/tidak lulus)
  - Student notifications
  - Excel export for records
  - Secure public access

### **🏢 Sarpras Management**
- **Features:**
  - Complete asset inventory
  - Barcode and QR code generation
  - Automatic barcode assignment
  - Room-based organization
- Category management
  - Condition tracking (baik/rusak/hilang)
  - Maintenance scheduling and tracking
  - Excel import/export
  - Barcode scanning capability
  - Inventory reports
  - Asset alerts and notifications

### **📄 Page Management**
- **Features:**
  - WYSIWYG content editor
  - SEO optimization (meta tags, descriptions)
  - Version control system
  - Draft/Published status
  - Menu integration
  - Custom templates
  - Image uploads
  - URL slug management
  - Category organization

### **📱 Instagram Integration**
- **Features:**
  - Auto-sync with Instagram Graph API
  - Post analytics and insights
  - Engagement tracking
- Content scheduling
  - Public gallery display
  - API configuration management
  - Token management
  - Connection testing

### **🔔 Notification System**
- **Features:**
  - Real-time dropdown notifications
  - Unread badge counter
  - Color-coded notification types
  - Mark as read functionality
  - Notification types:
    - 📢 Announcements
    - 🎓 Graduation status
    - 🗳️ Voting alerts
    - 📝 Data changes
    - ⚠️ System alerts
    - 🔒 Security notifications
    - ⏰ Reminders
  - Role-based targeting
  - Helper functions for easy integration

---

## 🎨 **Technology Stack**

### **Frontend**
- **CSS Framework:** Tailwind CSS 3.x
- **JavaScript:** Alpine.js 3.x
- **Icons:** Font Awesome 6.x
- **Build Tool:** Vite 5.x
- **Components:** Blade Components
- **Animations:** Alpine.js Transitions

### **Backend**
- **Framework:** Laravel 12.x
- **PHP Version:** 8.4
- **Database:** MySQL 8.0+ / MariaDB 10.3+
- **ORM:** Eloquent
- **Template Engine:** Blade
- **Authentication:** Laravel Breeze
- **Permissions:** Spatie Laravel Permission 6.x

### **Packages**
- **barryvdh/laravel-dompdf** - PDF generation
- **maatwebsite/excel** - Excel import/export
- **milon/barcode** - Barcode generation
- **spatie/laravel-permission** - Role management
- **laravel/breeze** - Authentication scaffolding

### **Development Tools**
- **Composer** - Dependency management
- **NPM** - Frontend package management
- **Git** - Version control
- **Laravel Debugbar** - Development debugging
- **Laravel Pint** - Code style fixing

---

## 📊 **Complete Database Schema**

### **Core Tables**
- `users` - User accounts (UUID, email, password, roles)
- `roles` - System roles (superadmin, admin, guru, siswa, sarpras)
- `permissions` - Granular permissions
- `model_has_roles` - User-role relationships
- `model_has_permissions` - User-permission relationships
- `role_has_permissions` - Role-permission relationships
- `notifications` - Database notifications
- `sessions` - User sessions
- `cache` - Application cache
- `jobs` - Queue jobs
- `failed_jobs` - Failed queue jobs

### **Academic Tables**
- `siswas` - Student records (UUID, nama, nisn, nis, kelas, jurusan)
- `gurus` - Teacher records (UUID, nama, nip, nuptk, subjects)
- `mata_pelajarans` - Subject management
- `kelas` - Class management
- `jurusan` - Department management
- `ekstrakurikulers` - Extracurricular activities

### **Module Tables**
- `calons` - OSIS candidates (UUID, nama, visi, misi, foto)
- `pemilihs` - Registered voters (UUID, user_id, gender)
- `votings` - Vote records (UUID, pemilih_id, calon_id)
- `osis_elections` - Election configuration
- `kelulusans` - Graduation data (UUID, nama, nisn, status)
- `barangs` - Asset inventory (UUID, kode_barang, nama, kondisi)
- `kategori_sarpras` - Asset categories
- `ruangs` - Room management
- `maintenances` - Maintenance records

### **System Tables**
- `pages` - Content pages (UUID, title, content, slug, seo)
- `page_categories` - Page categories
- `page_versions` - Version control
- `instagram_settings` - Instagram API configuration
- `audit_logs` - Activity tracking (user_id, action, description)
- `module_accesses` - Module access control

---

## 🛠️ **Development Guidelines**

### **Code Standards**
- Follow **PSR-12** coding standards
- Use **type hints** for all methods
- Write comprehensive **DocBlocks**
- Implement proper **error handling**
- Follow **SOLID principles**
- Use **dependency injection**

### **Best Practices**
- **Single Responsibility:** Each class/method has one job
- **DRY Principle:** Don't Repeat Yourself
- **Meaningful Names:** Use descriptive variable/method names
- **Security First:** Always validate and sanitize input
- **Performance:** Use eager loading, caching, and indexing
- **Testing:** Write tests for critical features

### **File Structure Best Practices**
```
app/
├── Console/Commands/        # Custom Artisan commands
├── Exports/                 # Excel export classes
├── Helpers/                 # Helper classes and functions
├── Http/
│   ├── Controllers/         # Application controllers
│   ├── Middleware/          # Custom middleware
│   └── Requests/            # Form request validation
├── Imports/                 # Excel import classes
├── Models/                  # Eloquent models
├── Notifications/           # Notification classes
├── Policies/                # Authorization policies
└── Services/                # Business logic services
```

---

## 📈 **Analytics & Monitoring**

### **Dashboard Analytics**
- User statistics and distribution
- Module usage metrics
- Real-time activity tracking
- Performance monitoring
- Engagement analytics
- Growth trends (last 6 months)

### **System Health**
- Database performance monitoring
- Cache system status
- Storage availability
- Memory usage tracking
- Disk space monitoring
- PHP version and extensions check

### **Reporting Capabilities**
- Student reports (Excel/PDF)
- Teacher performance
- Asset inventory reports
- Voting statistics
- Graduation reports
- Activity audit logs

---

## 🔒 **Security Best Practices**

### **Implemented Security Features**
✅ **Authentication & Authorization:**
- Email verification required
- Password hashing (bcrypt)
- Role-based access control
- Permission-based routes
- Session security

✅ **Data Protection:**
- CSRF token validation
- Input validation and sanitization
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)
- File upload validation
- Mass assignment protection

✅ **Application Security:**
- UUID primary keys (prevents enumeration)
- Secure session handling
- HTTPS enforcement (production)
- Rate limiting
- Error handling without sensitive info
- Audit logging for accountability

### **Security Recommendations**
1. Always use HTTPS in production
2. Keep dependencies updated
3. Use strong database passwords
4. Enable OPcache for PHP
5. Configure fail2ban for brute force protection
6. Regular security audits
7. Backup database regularly
8. Monitor logs for suspicious activity

---

## 🎯 **Helper Functions & Usage**

### **Notification Helper**
```php
use App\Helpers\NotificationHelper;

// Send to specific user
NotificationHelper::send($user, 'Title', 'Message', 'success');

// Send announcement to all
NotificationHelper::sendAnnouncement('Title', 'Message', 'info');

// Send to specific role
NotificationHelper::sendToRole('siswa', 'Title', 'Message');

// Welcome new user
NotificationHelper::sendWelcome($user);

// Graduation notification
NotificationHelper::sendGraduationStatus($user, 'lulus');

// Voting notification
NotificationHelper::sendVotingNotification('Title', 'Message');

// Shorthand function
notify($user, 'Title', 'Message', 'success');
```

### **Common Artisan Commands**
```bash
# Development
php artisan serve                    # Start dev server
php artisan optimize:clear          # Clear all caches
php artisan migrate:fresh --seed    # Fresh database with seeds

# Production
php artisan config:cache            # Cache configuration
php artisan route:cache             # Cache routes
php artisan view:cache              # Cache views
php artisan optimize                # Optimize for production

# Maintenance
php artisan down                    # Enable maintenance mode
php artisan up                      # Disable maintenance mode
php artisan queue:work              # Process queue jobs
php artisan schedule:run            # Run scheduled tasks
```

---

## 💡 **Tips & Tricks**

### **Development Tips**
1. Use `php artisan tinker` for testing code
2. Enable Laravel Debugbar for development
3. Use `dd()` for debugging
4. Check logs in `storage/logs/laravel.log`
5. Use `php artisan route:list` to see all routes
6. Test emails with Mailtrap/Mailhog locally

### **Performance Tips**
1. Enable OPcache in production
2. Use Redis for session and cache (optional)
3. Optimize images before upload
4. Use eager loading to prevent N+1 queries
5. Enable gzip compression
6. Minify CSS/JS files
7. Use CDN for static assets

### **Backup Strategy**
```bash
# Database backup
mysqldump -u username -p sekolah_db > backup_$(date +%Y%m%d).sql

# Files backup
tar -czf backup_files_$(date +%Y%m%d).tar.gz /var/www/sekolah

# Automated daily backup (add to crontab)
0 2 * * * /path/to/backup-script.sh
```

---

## 🏆 **Why Choose This System?**

### **✅ Production-Ready**
- Battle-tested Laravel 12.x framework
- Modern PHP 8.4 features
- Enterprise-grade architecture
- Comprehensive error handling
- Production-optimized configuration

### **✅ Feature-Rich**
- 8+ integrated modules
- Real-time notification system
- Complete role & permission management
- Instagram integration
- Analytics and monitoring
- Excel import/export for all modules

### **✅ Developer-Friendly**
- Clean, maintainable code
- Comprehensive documentation
- Reusable components
- Helper functions
- Easy customization
- Active development

### **✅ Secure & Scalable**
- OWASP security standards
- UUID for sensitive data
- Audit logging
- Input validation
- SQL injection prevention
- CSRF protection

### **✅ Performance Optimized**
- Server-side rendering
- Database query optimization
- Caching strategy
- Eager loading
- Asset optimization
- OPcache ready

---

## 📞 **Support & Community**

### **Getting Help**
- 📖 **Documentation:** Complete guides included
- 💬 **Community Forum:** [Forum Link]
- 📧 **Email Support:** support@wahyucode.com
- 🐛 **Bug Reports:** [GitHub Issues]
- 💡 **Feature Requests:** [GitHub Discussions]

### **Professional Services**
- 🔧 **Custom Development**
- 🚀 **Deployment Assistance**
- 📚 **Training & Workshops**
- 🛠️ **Technical Consultation**
- 💼 **Enterprise Support**

### **Stay Updated**
- ⭐ Star us on GitHub
- 🐦 Follow on Twitter [@wahyucode]
- 📺 Subscribe on YouTube [Wahyu Code Channel]
- 💼 Connect on LinkedIn

---

## 📄 **License & Commercial Use**

### **Commercial License**
This software is licensed under **Commercial License**.

**✅ You are allowed to:**
- Use for commercial projects
- Modify and customize source code
- Deploy on multiple domains (Extended License)
- Resell with modifications (Developer License)
- Create client projects
- Remove branding (Extended License)

**❌ You are NOT allowed to:**
- Redistribute the original source code
- Create derivative works for resale without Developer License
- Remove copyright notices without Extended License
- Use without proper licensing
- Claim as your own work

### **License Types**
1. **Single Use** - One domain/installation - $49
2. **Extended License** - Multiple domains - $199
3. **Developer License** - Unlimited projects - $499

---

## 🙏 **Credits & Acknowledgments**

### **Built With**
- **Laravel Framework** - Taylor Otwell and contributors
- **Tailwind CSS** - Adam Wathan and Tailwind Labs
- **Alpine.js** - Caleb Porzio
- **Spatie Packages** - Spatie Team
- **Font Awesome** - Fonticons, Inc.

### **Special Thanks**
- Open source community
- Laravel community
- All contributors and testers
- Early adopters and feedback providers

---

## 🚀 **Roadmap & Future Updates**

### **Planned Features**
- 📱 Mobile app (iOS/Android)
- 💬 Real-time chat system
- 📊 Advanced analytics dashboard
- 🔔 Push notifications
- 📧 Email newsletter system
- 🎯 Parent portal
- 📚 Digital library system
- 💳 Payment gateway integration
- 🌐 Multi-language support
- 🎨 Theme customization
- 📱 Progressive Web App (PWA)

### **Coming Soon**
- API documentation
- Video tutorials
- Plugin system
- Theme marketplace
- Mobile-responsive admin panel
- Advanced reporting tools

---

## 📊 **Statistics**

- **Total Files:** 400+
- **Lines of Code:** 15,000+
- **Database Tables:** 30+
- **Features:** 50+
- **User Roles:** 5
- **Modules:** 8
- **Development Time:** 200+ hours
- **Updates:** Regular
- **Support:** Active

---

## 🎨 **Branding**

### **Made with ❤️ by Wahyu Code**

> *"Building Excellence, One Line at a Time"*

**Wahyu Code** is dedicated to creating high-quality, production-ready software solutions for educational institutions. We believe in clean code, modern architecture, and user-friendly designs.

### **Our Philosophy**
- 💯 **Quality First:** Every line of code is crafted with care
- 🚀 **Performance Matters:** Optimized for speed and efficiency
- 🔒 **Security is Priority:** Your data, your trust
- 📱 **User Experience:** Beautiful, intuitive interfaces
- 🛠️ **Maintainability:** Clean, documented code
- 🌟 **Innovation:** Always improving, always evolving

---

**© 2024 Wahyu Code. All rights reserved.**

*Built with ❤️ using Laravel 12.x & Tailwind CSS*

**🌐 Website:** www.wahyucode.com  
**📧 Email:** hello@wahyucode.com  
**💼 LinkedIn:** /company/wahyucode  
**🐦 Twitter:** @wahyucode  
**📺 YouTube:** Wahyu Code Channel

---

**Need help? Have questions? Want to contribute?**  
We're here to help! Reach out anytime. 🚀

**⭐ Don't forget to star this repository if you find it useful!**
