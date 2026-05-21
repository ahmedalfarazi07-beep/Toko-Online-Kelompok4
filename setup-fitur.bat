@echo off
REM Quick Setup untuk Fitur Baru
REM Run ini setelah clone/pull changes

echo.
echo ====================================
echo Toko Online - Fitur Baru Setup
echo ====================================
echo.

cd /d c:\laragon\www\Toko-online

echo [1/3] Running Database Migrations...
call php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    pause
    exit /b 1
)

echo.
echo [2/3] Clearing caches...
call php artisan config:clear
call php artisan cache:clear

echo.
echo [3/3] Setup Complete!
echo.
echo ====================================
echo ✅ Fitur Baru Berhasil Diinstall!
echo ====================================
echo.
echo Dokumentasi:
echo  - FITUR_BARU.md              (Dokumentasi lengkap)
echo  - IMPLEMENTATION_CHECKLIST.md (Setup & integration)
echo  - README_NEW.md              (Project overview)
echo.
echo Langkah selanjutnya:
echo 1. composer dev          (Jalankan dev environment)
echo 2. Update views          (Lihat IMPLEMENTATION_CHECKLIST.md)
echo 3. Test di browser       (http://localhost:8000)
echo.
pause
