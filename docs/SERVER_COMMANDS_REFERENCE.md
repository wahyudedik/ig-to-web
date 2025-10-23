# 🖥️ Server Commands Reference

Quick reference untuk command-command yang sering digunakan dalam maintenance server production.

## 📦 System Management

### Update System
```bash
# Update package list
sudo apt update

# Upgrade packages
sudo apt upgrade -y

# Full upgrade with dependencies
sudo apt full-upgrade -y

# Clean up unused packages
sudo apt autoremove -y
sudo apt autoclean
```

### System Information
```bash
# OS version
lsb_release -a

# Kernel version
uname -r

# CPU info
lscpu

# Memory info
free -h

# Disk usage
df -h

# Disk usage by directory
du -sh /var/www/*

# System uptime
uptime

# Current users
who
```

---

## 🔧 Service Management

### Start/Stop/Restart Services
```bash
# Nginx
sudo systemctl start nginx
sudo systemctl stop nginx
sudo systemctl restart nginx
sudo systemctl reload nginx
sudo systemctl status nginx

# PHP-FPM
sudo systemctl start php8.1-fpm
sudo systemctl stop php8.1-fpm
sudo systemctl restart php8.1-fpm
sudo systemctl status php8.1-fpm

# MySQL
sudo systemctl start mysql
sudo systemctl stop mysql
sudo systemctl restart mysql
sudo systemctl status mysql

# Laravel Queue Worker
sudo systemctl start laravel-worker
sudo systemctl stop laravel-worker
sudo systemctl restart laravel-worker
sudo systemctl status laravel-worker

# Fail2Ban
sudo systemctl start fail2ban
sudo systemctl stop fail2ban
sudo systemctl restart fail2ban
sudo systemctl status fail2ban
```

### Enable/Disable Services
```bash
# Enable service on boot
sudo systemctl enable nginx
sudo systemctl enable php8.1-fpm
sudo systemctl enable mysql
sudo systemctl enable laravel-worker

# Disable service on boot
sudo systemctl disable service-name
```

---

## 🐘 PHP Commands

### PHP Version
```bash
# Check PHP version
php -v

# Check installed PHP modules
php -m

# Check specific module
php -m | grep mysql
```

### PHP Configuration
```bash
# PHP.ini location
php --ini

# Edit PHP.ini (FPM)
sudo nano /etc/php/8.1/fpm/php.ini

# Edit PHP.ini (CLI)
sudo nano /etc/php/8.1/cli/php.ini

# Test PHP configuration
php -i | grep error_log
```

### Composer
```bash
# Update Composer
composer self-update

# Install dependencies
composer install

# Install production dependencies only
composer install --no-dev --optimize-autoloader

# Update dependencies
composer update

# Clear Composer cache
composer clear-cache

# Dump autoload
composer dump-autoload
```

---

## 🎨 Laravel Artisan Commands

### Cache Management
```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create cache (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize application
php artisan optimize

# Clear compiled files
php artisan clear-compiled
```

### Database Commands
```bash
# Run migrations
php artisan migrate

# Run migrations (production)
php artisan migrate --force

# Rollback migrations
php artisan migrate:rollback

# Refresh migrations
php artisan migrate:refresh

# Fresh migrations with seed
php artisan migrate:fresh --seed

# Run seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UserSeeder

# Check migration status
php artisan migrate:status
```

### Queue Management
```bash
# Process queue
php artisan queue:work

# Process queue (with options)
php artisan queue:work --sleep=3 --tries=3 --timeout=90

# Process queue (daemon mode)
php artisan queue:work --daemon

# List failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry 5

# Retry all failed jobs
php artisan queue:retry all

# Forget failed job
php artisan queue:forget 5

# Flush all failed jobs
php artisan queue:flush

# Listen to queue
php artisan queue:listen
```

### Application Management
```bash
# Generate app key
php artisan key:generate

# Create storage link
php artisan storage:link

# List routes
php artisan route:list

# List routes (filtered)
php artisan route:list --name=user

# Show application about
php artisan about

# Enter tinker (REPL)
php artisan tinker

# Run scheduler
php artisan schedule:run

# Test scheduler
php artisan schedule:list
```

### Maintenance Mode
```bash
# Enable maintenance mode
php artisan down

# Enable with secret
php artisan down --secret="your-secret-token"

# Disable maintenance mode
php artisan up
```

---

## 💾 MySQL Commands

### MySQL Service
```bash
# Login to MySQL
mysql -u root -p

# Login with specific database
mysql -u username -p database_name

# Exit MySQL
exit;
```

### Database Operations
```sql
-- Show databases
SHOW DATABASES;

-- Use database
USE ig_to_web;

-- Show tables
SHOW TABLES;

-- Describe table
DESCRIBE users;

-- Show table status
SHOW TABLE STATUS;

-- Show create table
SHOW CREATE TABLE users;

-- Count records
SELECT COUNT(*) FROM users;

-- Show processlist
SHOW PROCESSLIST;

-- Kill process
KILL process_id;

-- Create database
CREATE DATABASE ig_to_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';

-- Grant privileges
GRANT ALL PRIVILEGES ON database.* TO 'username'@'localhost';

-- Flush privileges
FLUSH PRIVILEGES;

-- Show grants
SHOW GRANTS FOR 'username'@'localhost';
```

### Backup & Restore
```bash
# Backup single database
mysqldump -u username -p database_name > backup.sql

# Backup with compression
mysqldump -u username -p database_name | gzip > backup.sql.gz

# Backup all databases
mysqldump -u root -p --all-databases > all_databases.sql

# Backup specific tables
mysqldump -u username -p database_name table1 table2 > tables_backup.sql

# Restore database
mysql -u username -p database_name < backup.sql

# Restore compressed backup
gunzip < backup.sql.gz | mysql -u username -p database_name
```

---

## 🌐 Nginx Commands

### Configuration Test
```bash
# Test configuration
sudo nginx -t

# Test and show details
sudo nginx -T

# Reload configuration
sudo nginx -s reload

# Stop Nginx gracefully
sudo nginx -s quit

# Stop Nginx fast
sudo nginx -s stop
```

### Log Management
```bash
# View error log
sudo tail -f /var/log/nginx/error.log

# View access log
sudo tail -f /var/log/nginx/access.log

# View last 100 lines
sudo tail -n 100 /var/log/nginx/error.log

# Search in logs
sudo grep "404" /var/log/nginx/access.log

# Count 404 errors
sudo grep "404" /var/log/nginx/access.log | wc -l

# Rotate logs
sudo nginx -s reopen
```

---

## 🔐 SSL Certificate (Let's Encrypt)

### Certbot Commands
```bash
# Obtain certificate
sudo certbot --nginx -d yourdomain.com

# Obtain wildcard certificate
sudo certbot certonly --manual --preferred-challenges dns -d "*.yourdomain.com"

# Renew certificates
sudo certbot renew

# Renew specific certificate
sudo certbot renew --cert-name yourdomain.com

# Test renewal
sudo certbot renew --dry-run

# List certificates
sudo certbot certificates

# Delete certificate
sudo certbot delete --cert-name yourdomain.com

# Force renewal
sudo certbot renew --force-renewal
```

---

## 🔥 Firewall (UFW)

### UFW Commands
```bash
# Enable UFW
sudo ufw enable

# Disable UFW
sudo ufw disable

# Status
sudo ufw status
sudo ufw status verbose
sudo ufw status numbered

# Allow port
sudo ufw allow 80
sudo ufw allow 443
sudo ufw allow 22/tcp

# Deny port
sudo ufw deny 8080

# Delete rule
sudo ufw delete allow 80
sudo ufw delete 2  # by number

# Reset UFW
sudo ufw reset

# Default policies
sudo ufw default deny incoming
sudo ufw default allow outgoing
```

---

## 📊 Monitoring Commands

### Process Monitoring
```bash
# Interactive process viewer
htop

# Simple process list
top

# Process tree
pstree

# Find process by name
ps aux | grep nginx

# Kill process
kill PID
kill -9 PID  # force kill

# Kill by name
pkill nginx
killall nginx
```

### Network Monitoring
```bash
# Show network connections
sudo netstat -tulpn

# Show listening ports
sudo ss -tulpn

# Network bandwidth by process
sudo nethogs

# Network statistics
netstat -s

# Check port
sudo lsof -i :80
sudo lsof -i :3306

# Test connection
telnet yourdomain.com 80
nc -zv yourdomain.com 80
```

### Disk I/O Monitoring
```bash
# I/O statistics
iostat

# Disk I/O by process
sudo iotop

# Disk usage
df -h

# Inode usage
df -i

# Find large files
sudo find / -type f -size +100M

# Disk usage by directory
du -sh /*
du -h --max-depth=1 /var/www/
```

---

## 📝 Log Management

### View Logs
```bash
# Laravel logs
tail -f /var/www/ig-to-web/storage/logs/laravel.log

# Nginx error log
tail -f /var/log/nginx/error.log

# Nginx access log
tail -f /var/log/nginx/access.log

# MySQL error log
tail -f /var/log/mysql/error.log

# System log
tail -f /var/log/syslog

# Auth log
tail -f /var/log/auth.log

# PHP-FPM log
tail -f /var/log/php8.1-fpm.log
```

### Log Analysis
```bash
# Count errors
grep "ERROR" /var/www/ig-to-web/storage/logs/laravel.log | wc -l

# Find specific error
grep "Connection refused" /var/www/ig-to-web/storage/logs/laravel.log

# View errors from last hour
grep "$(date +%Y-%m-%d\ %H)" /var/www/ig-to-web/storage/logs/laravel.log | grep ERROR

# Count 500 errors
grep " 500 " /var/log/nginx/access.log | wc -l

# Top 10 IP addresses
awk '{print $1}' /var/log/nginx/access.log | sort | uniq -c | sort -rn | head -10

# Top 10 requested URLs
awk '{print $7}' /var/log/nginx/access.log | sort | uniq -c | sort -rn | head -10
```

### Clear Logs
```bash
# Clear Laravel logs
truncate -s 0 /var/www/ig-to-web/storage/logs/laravel.log

# Clear Nginx logs
sudo truncate -s 0 /var/log/nginx/error.log
sudo truncate -s 0 /var/log/nginx/access.log

# Archive and clear
sudo tar -czf /var/backups/nginx-logs-$(date +%Y%m%d).tar.gz /var/log/nginx/*.log
sudo truncate -s 0 /var/log/nginx/*.log
```

---

## 🔒 Security Commands

### Fail2Ban
```bash
# Status
sudo fail2ban-client status

# Status of specific jail
sudo fail2ban-client status nginx-http-auth

# Unban IP
sudo fail2ban-client set nginx-http-auth unbanip 1.2.3.4

# Ban IP manually
sudo fail2ban-client set nginx-http-auth banip 1.2.3.4

# Check banned IPs
sudo fail2ban-client status nginx-http-auth | grep "Banned IP"
```

### File Permissions
```bash
# Change ownership
sudo chown user:group file

# Change ownership recursively
sudo chown -R www-data:www-data /var/www/ig-to-web

# Change permissions
sudo chmod 755 directory
sudo chmod 644 file

# Change permissions recursively
sudo chmod -R 755 /var/www/ig-to-web

# Find and fix permissions
find /var/www/ig-to-web -type d -exec chmod 755 {} \;
find /var/www/ig-to-web -type f -exec chmod 644 {} \;

# Special permissions for Laravel
sudo chmod -R 775 /var/www/ig-to-web/storage
sudo chmod -R 775 /var/www/ig-to-web/bootstrap/cache
```

---

## 💾 Backup Commands

### Manual Backup
```bash
# Backup database
mysqldump -u ig_to_web_user -p ig_to_web | gzip > /var/backups/database-$(date +%Y%m%d-%H%M%S).sql.gz

# Backup files
tar -czf /var/backups/files-$(date +%Y%m%d-%H%M%S).tar.gz /var/www/ig-to-web

# Backup specific directories
tar -czf /var/backups/storage-$(date +%Y%m%d-%H%M%S).tar.gz /var/www/ig-to-web/storage

# Sync to remote server (rsync)
rsync -avz /var/backups/ user@remote-server:/backups/ig-to-web/
```

### Restore from Backup
```bash
# Restore database
gunzip < /var/backups/database-20240101-120000.sql.gz | mysql -u ig_to_web_user -p ig_to_web

# Restore files
tar -xzf /var/backups/files-20240101-120000.tar.gz -C /
```

---

## 🔄 Git Commands

### Repository Management
```bash
# Check status
git status

# Pull latest changes
git pull origin main

# Checkout specific branch
git checkout production

# Create new branch
git checkout -b feature/new-feature

# View commit history
git log --oneline -10

# Show current branch
git branch

# Fetch from remote
git fetch origin

# Reset to origin
git reset --hard origin/main

# Stash changes
git stash
git stash pop
```

### After Git Pull (Production Update)
```bash
# After pulling changes
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl restart php8.1-fpm
sudo systemctl restart laravel-worker
```

---

## 🚨 Emergency Commands

### Out of Disk Space
```bash
# Find large files
find / -type f -size +100M -exec ls -lh {} \;

# Clean package cache
sudo apt clean

# Clean journal logs
sudo journalctl --vacuum-time=3d

# Clear Laravel cache
cd /var/www/ig-to-web
php artisan cache:clear
php artisan view:clear

# Remove old log files
find /var/www/ig-to-web/storage/logs -name "*.log" -mtime +30 -delete
```

### High CPU Usage
```bash
# Find CPU-intensive processes
top -o %CPU

# Check PHP processes
ps aux | grep php | wc -l

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm

# Check slow queries
sudo tail -f /var/log/mysql/mysql-slow.log
```

### Out of Memory
```bash
# Check memory
free -h

# Clear cache
sudo sync; echo 3 > /proc/sys/vm/drop_caches

# Restart services
sudo systemctl restart php8.1-fpm
sudo systemctl restart mysql
```

### Database Issues
```bash
# Check MySQL errors
sudo tail -f /var/log/mysql/error.log

# Repair tables
mysqlcheck -u root -p --auto-repair --all-databases

# Optimize tables
mysqlcheck -u root -p --optimize --all-databases

# Reset root password (if locked out)
sudo systemctl stop mysql
sudo mysqld_safe --skip-grant-tables &
mysql -u root
mysql> FLUSH PRIVILEGES;
mysql> ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_password';
mysql> exit;
sudo systemctl restart mysql
```

---

## 📌 Useful One-Liners

```bash
# Check what's eating disk space
du -h / 2>/dev/null | sort -rh | head -20

# Find and delete empty directories
find /path -type d -empty -delete

# Count files in directory
ls -1 | wc -l

# Watch command (auto-refresh)
watch -n 1 'ps aux | grep php'

# Monitor log in real-time with search
tail -f /var/log/nginx/access.log | grep --line-buffered "404"

# Check if port is open
timeout 1 bash -c 'cat < /dev/null > /dev/tcp/localhost/80'

# Get public IP
curl ifconfig.me

# Test website response time
curl -o /dev/null -s -w 'Total: %{time_total}s\n' https://yourdomain.com
```

---

**Pro Tip:** Bookmark this page and keep it handy for quick reference! 📚


