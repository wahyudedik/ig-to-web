# Setup Script untuk MCP Server
# Jalankan dengan: .\setup.ps1

Write-Host "==================================" -ForegroundColor Cyan
Write-Host "MCP Server Setup untuk IG-to-Web" -ForegroundColor Cyan
Write-Host "==================================" -ForegroundColor Cyan
Write-Host ""

# Check Node.js
Write-Host "Checking Node.js..." -ForegroundColor Yellow
try {
    $nodeVersion = node --version
    Write-Host "✓ Node.js terinstall: $nodeVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ Node.js tidak ditemukan!" -ForegroundColor Red
    Write-Host "  Download dari: https://nodejs.org/" -ForegroundColor Yellow
    exit 1
}

# Check npm
Write-Host "Checking npm..." -ForegroundColor Yellow
try {
    $npmVersion = npm --version
    Write-Host "✓ npm terinstall: $npmVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ npm tidak ditemukan!" -ForegroundColor Red
    exit 1
}

# Install dependencies
Write-Host ""
Write-Host "Installing dependencies..." -ForegroundColor Yellow
npm install

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Dependencies berhasil diinstall" -ForegroundColor Green
} else {
    Write-Host "✗ Gagal install dependencies" -ForegroundColor Red
    exit 1
}

# Get current directory
$currentPath = (Get-Location).Path
$parentPath = Split-Path -Parent $currentPath
$configPath = "$env:APPDATA\Claude\claude_desktop_config.json"

Write-Host ""
Write-Host "==================================" -ForegroundColor Cyan
Write-Host "Setup Selesai!" -ForegroundColor Green
Write-Host "==================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. Buka file konfigurasi Claude Desktop:" -ForegroundColor White
Write-Host "   $configPath" -ForegroundColor Cyan
Write-Host ""
Write-Host "2. Tambahkan konfigurasi berikut:" -ForegroundColor White
Write-Host @"
{
  "mcpServers": {
    "ig-to-web": {
      "command": "node",
      "args": ["$currentPath\index.js"],
      "cwd": "$currentPath"
    }
  }
}
"@ -ForegroundColor Cyan
Write-Host ""
Write-Host "3. Restart Claude Desktop" -ForegroundColor White
Write-Host ""
Write-Host "Untuk test server, jalankan: npm start" -ForegroundColor Yellow

