@echo off
echo ==================================
echo MCP Server Setup untuk IG-to-Web
echo ==================================
echo.

REM Check Node.js
echo Checking Node.js...
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Node.js tidak ditemukan!
    echo Download dari: https://nodejs.org/
    pause
    exit /b 1
)
echo [OK] Node.js terinstall
echo.

REM Check npm
echo Checking npm...
npm --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] npm tidak ditemukan!
    pause
    exit /b 1
)
echo [OK] npm terinstall
echo.

REM Install dependencies
echo Installing dependencies...
call npm install
if %errorlevel% neq 0 (
    echo [ERROR] Gagal install dependencies
    pause
    exit /b 1
)
echo [OK] Dependencies berhasil diinstall
echo.

echo ==================================
echo Setup Selesai!
echo ==================================
echo.
echo Langkah selanjutnya:
echo.
echo 1. Buka file konfigurasi Claude Desktop:
echo    %%APPDATA%%\Claude\claude_desktop_config.json
echo.
echo 2. Tambahkan konfigurasi (lihat claude_desktop_config.example.json)
echo.
echo 3. Restart Claude Desktop
echo.
echo Untuk test server, jalankan: npm test
echo.
pause

