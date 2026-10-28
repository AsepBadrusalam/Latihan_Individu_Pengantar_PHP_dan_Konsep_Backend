@echo off
setlocal

rem ============================================================
rem  Jalankan proyek ini tanpa perlu PHP ada di PATH.
rem  Pakai: start.bat          (port default 8000)
rem         start.bat 8080     (port lain)
rem ============================================================

set "PORT=%~1"
if "%PORT%"=="" set "PORT=8000"

set "PHP_BIN="

rem 1) Cek PHP yang sudah ada di PATH
where php >nul 2>nul && set "PHP_BIN=php"

rem 2) Cek XAMPP
if not defined PHP_BIN if exist "C:\xampp\php\php.exe" set "PHP_BIN=C:\xampp\php\php.exe"

rem 3) Cek Laragon
if not defined PHP_BIN (
    for /d %%D in ("C:\laragon\bin\php\php-*") do (
        if exist "%%~fD\php.exe" set "PHP_BIN=%%~fD\php.exe"
    )
)

if not defined PHP_BIN (
    echo.
    echo [X] PHP tidak ditemukan.
    echo.
    echo Install salah satu dari berikut, lalu jalankan file ini lagi:
    echo   - XAMPP          : https://www.apachefriends.org/download.html
    echo   - PHP for Windows: https://windows.php.net/download  ^(pilih VS16 x64 Thread Safe^)
    echo.
    pause
    exit /b 1
)

echo.
echo [i] Menggunakan PHP:
"%PHP_BIN%" -v | findstr /i "PHP"
echo [i] Folder proyek : %~dp0
echo [i] Alamat        : http://localhost:%PORT%
echo [i] Tekan Ctrl+C untuk menghentikan server.
echo.

start "" "http://localhost:%PORT%"
"%PHP_BIN%" -S localhost:%PORT% -t "%~dp0"

endlocal
