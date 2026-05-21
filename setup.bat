@echo off
REM Setup development environment
cd /d c:\laragon\www\Toko-online

echo ====================================
echo 1. Installing composer dependencies
echo ====================================
call composer install

echo.
echo ====================================
echo 2. Copying .env file
echo ====================================
if not exist .env (
    copy .env.example .env
    echo .env file created
) else (
    echo .env already exists
)

echo.
echo ====================================
echo 3. Generating app key
echo ====================================
call php artisan key:generate

echo.
echo ====================================
echo 4. Running database migrations
echo ====================================
call php artisan migrate --force

echo.
echo ====================================
echo 5. Installing npm dependencies
echo ====================================
call npm install --ignore-scripts

echo.
echo ====================================
echo 6. Building frontend assets
echo ====================================
call npm run build

echo.
echo ====================================
echo Setup Completed!
echo ====================================
pause
