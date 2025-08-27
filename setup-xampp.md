# XAMPP Setup Guide for Singularity Compliance SaaS

## Step 1: Download & Install XAMPP

### Download XAMPP
1. **Open your web browser**
2. **Go to**: https://www.apachefriends.org/download.html
3. **Click**: "XAMPP for Windows" (latest version - usually PHP 8.2)
4. **Download** the installer (approximately 150MB)

### Install XAMPP
1. **Run** the downloaded installer as Administrator
2. **Select Components** (keep defaults):
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
   - ✅ phpMyAdmin
   - ❌ Uncheck others (optional)
3. **Installation Directory**: `C:\xampp` (keep default)
4. **Click**: Install and wait for completion
5. **Start XAMPP Control Panel** when prompted

## Step 2: Start XAMPP Services

### Launch XAMPP Control Panel
1. **Find XAMPP** in Start Menu or Desktop
2. **Run as Administrator** (important!)
3. **Start Services**:
   - Click **"Start"** next to **Apache** (should turn green)
   - Click **"Start"** next to **MySQL** (should turn green)

### Verify Services
- Both Apache and MySQL should show **green "Running"** status
- If ports 80/443 are in use, click **"Config"** > **"Service and Port Settings"** > change Apache to port 8080

## Step 3: Setup Your Project Files

### Copy Project to XAMPP Directory
1. **Navigate to**: `C:\xampp\htdocs\`
2. **Create new folder**: `singularity`
3. **Copy all contents** from your `html` folder to `C:\xampp\htdocs\singularity\`

### File Structure Should Look Like:
```
C:\xampp\htdocs\singularity\
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── admin-demo.php
├── config/
│   ├── database.php
│   └── constants.php
├── includes/
├── classes/
├── assets/
└── uploads/
```

## Step 4: Setup Database

### Access phpMyAdmin
1. **Open browser**
2. **Go to**: http://localhost/phpmyadmin
3. **Click**: "New" (on left sidebar)
4. **Database name**: `compliance_saas`
5. **Collation**: `utf8mb4_general_ci`
6. **Click**: "Create"

### Import Database Schema
1. **Select** your new `compliance_saas` database
2. **Click**: "SQL" tab at the top
3. **Copy the entire contents** of the file below and paste it
4. **Click**: "Go" to execute

## Step 5: Test Your Application

### Test URLs
- **Homepage**: http://localhost/singularity/
- **Admin Demo**: http://localhost/singularity/admin-demo.php
- **Login Page**: http://localhost/singularity/login.php
- **Registration**: http://localhost/singularity/register.php

### Default Test Account
After database setup, you can login with:
- **Email**: admin@system.local
- **Password**: password

## Troubleshooting

### Apache Won't Start (Port 80 in use)
1. **Click "Config"** next to Apache
2. **Select "Apache (httpd.conf)"**
3. **Find line**: `Listen 80`
4. **Change to**: `Listen 8080`
5. **Save and restart Apache**
6. **Access via**: http://localhost:8080/singularity/

### MySQL Won't Start (Port 3306 in use)
1. **Stop any existing MySQL services**
2. **In XAMPP, click "Config"** next to MySQL
3. **Change port** from 3306 to 3307 if needed

### Permission Issues
1. **Run XAMPP Control Panel as Administrator**
2. **Right-click** on `C:\xampp\htdocs\singularity` folder
3. **Properties > Security > Edit**
4. **Give "Full Control"** to your user account

## Quick Commands

### Start XAMPP Services (via CMD)
```cmd
cd C:\xampp
xampp-control.exe
```

### Test PHP
Create a file `C:\xampp\htdocs\test.php`:
```php
<?php
phpinfo();
?>
```
Visit: http://localhost/test.php

---

## 🎉 Success Indicators

✅ **XAMPP Control Panel** shows Apache and MySQL as "Running" (green)
✅ **http://localhost/** shows XAMPP dashboard
✅ **http://localhost/phpmyadmin** opens database management
✅ **http://localhost/singularity/** shows your application homepage
✅ **http://localhost/singularity/admin-demo.php** shows the professional admin interface

---

**Need Help?** If you encounter any issues, let me know which step failed and I'll help troubleshoot!