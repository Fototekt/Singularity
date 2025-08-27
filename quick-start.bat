@echo off
echo ================================================
echo    Singularity Compliance SaaS - Quick Setup
echo ================================================
echo.

REM Check if XAMPP is installed
if not exist "C:\xampp\xampp-control.exe" (
    echo [ERROR] XAMPP not found at C:\xampp\
    echo Please install XAMPP first from: https://www.apachefriends.org/
    echo Then run this script again.
    pause
    exit /b 1
)

echo [1/4] Checking XAMPP installation... ✓
echo.

REM Create project directory
if not exist "C:\xampp\htdocs\singularity" (
    mkdir "C:\xampp\htdocs\singularity"
    echo [2/4] Created project directory... ✓
) else (
    echo [2/4] Project directory already exists... ✓
)
echo.

REM Copy project files
echo [3/4] Copying project files...
xcopy "html\*" "C:\xampp\htdocs\singularity\" /E /I /Y > nul 2>&1
if %errorlevel% equ 0 (
    echo [3/4] Project files copied successfully... ✓
) else (
    echo [3/4] Warning: Some files may not have copied correctly
)
echo.

REM Start XAMPP Control Panel
echo [4/4] Starting XAMPP Control Panel...
start "" "C:\xampp\xampp-control.exe"
echo [4/4] XAMPP Control Panel launched... ✓
echo.

echo ================================================
echo                 SETUP COMPLETE!
echo ================================================
echo.
echo Next Steps:
echo 1. In XAMPP Control Panel, click START for:
echo    - Apache (web server)
echo    - MySQL (database)
echo.
echo 2. Open browser and go to:
echo    http://localhost/phpmyadmin
echo.
echo 3. Create database 'compliance_saas' and import:
echo    database-import.sql
echo.
echo 4. Test your application:
echo    - Homepage: http://localhost/singularity/
echo    - Admin Demo: http://localhost/singularity/admin-demo.php
echo    - Login: admin@system.local / password
echo.
echo 5. If port 80 is busy, change Apache to port 8080
echo    Then use: http://localhost:8080/singularity/
echo.
echo ================================================
pause