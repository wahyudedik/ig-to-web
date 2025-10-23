# ✅ VPS Deployment Checklist

Checklist lengkap untuk deployment Laravel IG-to-Web ke VPS Ubuntu.

## 📋 Pre-Deployment

### Server Requirements
- [ ] VPS dengan Ubuntu 20.04 atau 22.04 LTS
- [ ] Minimum 2GB RAM
- [ ] Minimum 20GB storage
- [ ] Root atau sudo access
- [ ] Domain sudah pointing ke server IP

### Tools & Credentials
- [ ] SSH client (PuTTY/Terminal)
- [ ] Domain name
- [ ] MySQL root password
- [ ] Email SMTP credentials
- [ ] Instagram API credentials (optional)
- [ ] GitHub repository access

---

## 🚀 Phase 1: Server Preparation (30 menit)

### 1.1 Initial Setup
- [ ] Login ke server via SSH
- [ ] Update sistem: `sudo apt update && sudo apt upgrade -y`
- [ ] Install essential packages: `sudo apt install -y software-properties-common curl wget git unzip`
- [ ] Create non-root user (recommended)

### 1.2 Firewall Setup
- [ ] Enable UFW: `sudo ufw enable`
- [ ] Allow SSH: `sudo ufw allow 22/tcp`
- [ ] Allow HTTP: `sudo ufw allow 80/tcp`
- [ ] Allow HTTPS: `sudo ufw allow 443/tcp`
- [ ] Verify: `sudo ufw status`

### 1.3 Install PHP 8.1
- [ ] Add PHP repository
- [ ] Install PHP 8.1 dan extensions
- [ ] Verify: `php -v`
- [ ] Configure PHP settings (upload_max_filesize, memory_limit, dll)
- [ ] Restart PHP-FPM

### 1.4 Install Composer
- [ ] Download Composer
- [ ] Move to /usr/local/bin/composer
- [ ] Make executable
- [ ] Verify: `composer --version`

### 1.5 Install Node.js
- [ ] Install Node.js 18.x LTS
- [ ] Verify: `node --version` dan `npm --version`
- [ ] (Optional) Install Yarn

### 1.6 Install MySQL
- [ ] Install MySQL Server
- [ ] Run mysql_secure_installation
- [ ] Create database: `ig_to_web`
- [ ] Create user dan grant privileges
- [ ] Configure MySQL settings
- [ ] Restart MySQL

### 1.7 Install Nginx
- [ ] Install Nginx
- [ ] Start dan enable service
- [ ] Verify: `sudo systemctl status nginx`

### 1.8 Install SSL Certificate
- [ ] Install Certbot
- [ ] Obtain SSL certificate
- [ ] Test auto-renewal
- [ ] Setup cron job for renewal

---

## 📦 Phase 2: Application Deployment (20 menit)

### 2.1 Clone Repository
- [ ] Create directory: `/var/www/ig-to-web`
- [ ] Set ownership
- [ ] Clone Git repository
- [ ] CD to project directory

### 2.2 Install Dependencies
- [ ] Run: `composer install --optimize-autoloader --no-dev`
- [ ] Run: `npm install`
- [ ] Run: `npm run build`

### 2.3 Environment Configuration
- [ ] Copy .env.example to .env
- [ ] Generate app key: `php artisan key:generate`
- [ ] Configure database credentials
- [ ] Configure mail settings
- [ ] Set APP_ENV=production
- [ ] Set APP_DEBUG=false
- [ ] Set APP_URL

### 2.4 Database Setup
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Run seeders: `php artisan db:seed --force`
- [ ] Verify database tables

### 2.5 Storage & Permissions
- [ ] Create storage link: `php artisan storage:link`
- [ ] Set ownership to www-data
- [ ] Set directory permissions (755)
- [ ] Set storage permissions (775)
- [ ] Set bootstrap/cache permissions (775)

### 2.6 Cache Optimization
- [ ] Run: `php artisan config:cache`
- [ ] Run: `php artisan route:cache`
- [ ] Run: `php artisan view:cache`
- [ ] Run: `php artisan optimize`

---

## ⚙️ Phase 3: Server Configuration (20 menit)

### 3.1 Nginx Configuration
- [ ] Create site config: `/etc/nginx/sites-available/ig-to-web`
- [ ] Add server configuration
- [ ] Enable site (symbolic link)
- [ ] Remove default site
- [ ] Test config: `sudo nginx -t`
- [ ] Reload Nginx

### 3.2 Queue Worker Setup
- [ ] Create systemd service: `/etc/systemd/system/laravel-worker.service`
- [ ] Reload systemd: `sudo systemctl daemon-reload`
- [ ] Enable service
- [ ] Start service
- [ ] Check status

### 3.3 Scheduler Setup
- [ ] Edit crontab: `sudo crontab -e`
- [ ] Add Laravel scheduler line
- [ ] Verify cron is running

### 3.4 Log Rotation
- [ ] Create logrotate config: `/etc/logrotate.d/laravel`
- [ ] Test logrotate: `sudo logrotate -d /etc/logrotate.d/laravel`

---

## 🔒 Phase 4: Security Hardening (15 menit)

### 4.1 Fail2Ban Setup
- [ ] Install Fail2Ban
- [ ] Configure jail.local
- [ ] Enable Nginx protections
- [ ] Restart Fail2Ban
- [ ] Check status

### 4.2 SSH Hardening
- [ ] Setup SSH key authentication
- [ ] Disable root login
- [ ] Disable password authentication (after SSH key setup)
- [ ] Change default SSH port (optional)
- [ ] Restart SSH service

### 4.3 Additional Security
- [ ] Enable automatic security updates
- [ ] Setup intrusion detection (optional)
- [ ] Configure iptables rules (optional)
- [ ] Setup monitoring alerts

---

## 🔍 Phase 5: Testing & Verification (10 menit)

### 5.1 Application Testing
- [ ] Visit https://yourdomain.com
- [ ] Test login dengan superadmin account
- [ ] Check all major pages load correctly
- [ ] Test file upload functionality
- [ ] Verify email sending works
- [ ] Check Instagram integration (if configured)

### 5.2 Performance Testing
- [ ] Check page load times
- [ ] Verify Gzip compression works
- [ ] Check static assets caching
- [ ] Test SSL/HTTPS configuration
- [ ] Run security scan (SSL Labs)

### 5.3 Monitoring Setup
- [ ] Verify queue worker is running
- [ ] Check cron jobs are executing
- [ ] Monitor error logs
- [ ] Check disk space usage
- [ ] Verify backup script works

---

## 📊 Phase 6: Monitoring & Maintenance Setup (10 menit)

### 6.1 Backup Configuration
- [ ] Create backup script
- [ ] Make script executable
- [ ] Test backup manually
- [ ] Setup backup cron job
- [ ] Verify backup location

### 6.2 Monitoring Tools
- [ ] Install htop
- [ ] Install iotop
- [ ] Install nethogs
- [ ] Setup log monitoring
- [ ] Configure uptime monitoring (optional)

### 6.3 Documentation
- [ ] Document server credentials (securely)
- [ ] Document database credentials
- [ ] Document API keys
- [ ] Create runbook for common issues
- [ ] Share access with team

---

## 🎯 Post-Deployment Checklist

### Immediate Actions (Day 1)
- [ ] Monitor application logs for errors
- [ ] Check server resources (CPU, RAM, disk)
- [ ] Verify all cron jobs ran successfully
- [ ] Test backup restoration
- [ ] Monitor queue worker status

### First Week
- [ ] Review error logs daily
- [ ] Monitor database performance
- [ ] Check SSL certificate validity
- [ ] Review security logs
- [ ] Test disaster recovery plan

### Ongoing Maintenance
- [ ] Weekly security updates
- [ ] Monthly backup verification
- [ ] Quarterly performance review
- [ ] Regular penetration testing
- [ ] Update documentation as needed

---

## 🆘 Troubleshooting Quick Reference

### Common Issues

#### Application Not Loading
```bash
# Check Nginx status
sudo systemctl status nginx

# Check PHP-FPM
sudo systemctl status php8.1-fpm

# Check error logs
tail -f /var/log/nginx/error.log
tail -f /var/www/ig-to-web/storage/logs/laravel.log
```

#### Database Connection Issues
```bash
# Check MySQL status
sudo systemctl status mysql

# Test database connection
mysql -u ig_to_web_user -p ig_to_web

# Check Laravel database config
php artisan config:clear
php artisan config:cache
```

#### Permission Errors
```bash
# Fix ownership
sudo chown -R www-data:www-data /var/www/ig-to-web

# Fix permissions
sudo chmod -R 755 /var/www/ig-to-web
sudo chmod -R 775 /var/www/ig-to-web/storage
sudo chmod -R 775 /var/www/ig-to-web/bootstrap/cache
```

#### Queue Not Processing
```bash
# Check queue worker status
sudo systemctl status laravel-worker

# Restart queue worker
sudo systemctl restart laravel-worker

# View queue logs
tail -f /var/www/ig-to-web/storage/logs/laravel.log
```

#### SSL Certificate Issues
```bash
# Check certificate
sudo certbot certificates

# Renew certificate manually
sudo certbot renew

# Test renewal
sudo certbot renew --dry-run
```

---

## 📱 Emergency Contacts & Resources

### Documentation
- Main README: `/var/www/ig-to-web/README.md`
- Laravel Docs: https://laravel.com/docs
- Nginx Docs: https://nginx.org/en/docs/

### Logs Location
- Nginx Error: `/var/log/nginx/error.log`
- Nginx Access: `/var/log/nginx/access.log`
- Laravel: `/var/www/ig-to-web/storage/logs/laravel.log`
- MySQL: `/var/log/mysql/error.log`
- System: `/var/log/syslog`

### Useful Commands
```bash
# View running processes
htop

# Check disk space
df -h

# Check memory usage
free -m

# Check open ports
sudo netstat -tulpn

# Check failed login attempts
sudo tail /var/log/auth.log

# View systemd service logs
sudo journalctl -u laravel-worker -f
```

---

## ✅ Deployment Complete!

Congratulations! Your Laravel IG-to-Web application is now deployed to production.

**Next Steps:**
1. Monitor application for first 24-48 hours
2. Setup additional monitoring (New Relic, DataDog, etc.)
3. Configure CDN for static assets
4. Setup staging environment
5. Plan for scaling if needed

**Remember:**
- Keep all systems updated
- Monitor logs regularly
- Test backups monthly
- Review security quarterly
- Document all changes

---

**Deployment Date:** _______________

**Deployed By:** _______________

**Server IP:** _______________

**Domain:** _______________

**Notes:**
_______________________________________________________________
_______________________________________________________________
_______________________________________________________________

