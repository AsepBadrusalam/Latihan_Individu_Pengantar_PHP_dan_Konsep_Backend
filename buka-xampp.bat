@echo off
setlocal EnableExtensions

rem ============================================================
rem  Buka proyek ini lewat Apache XAMPP (http://localhost/pemweb)
rem
rem  Cara pakai : dobel-klik file ini
rem  Syarat     : XAMPP terpasang (default C:\xampp)
rem
rem  Script akan:
rem   1. menyalakan Apache bila belum berjalan
rem   2. menyambungkan folder proyek ke htdocs\pemweb (junction,
rem      tidak menyalin file, jadi edit langsung terlihat)
rem   3. membuka browser ke http://localhost/pemweb/
rem ============================================================

set "XAMPP_DIR=C:\xampp"
if not exist "%XAMPP_DIR%\apache\bin\httpd.exe" if defined XAMPP_HOME set "XAMPP_DIR=%XAMPP_HOME%"

if not exist "%XAMPP_DIR%\apache\bin\httpd.exe" (
    echo.
    echo [X] XAMPP tidak ditemukan di "%XAMPP_DIR%".
    echo     Install XAMPP dari https://www.apachefriends.org/download.html
    echo     atau set variabel XAMPP_HOME ke folder XAMPP kamu.
    echo.
    pause
    exit /b 1
)

set "PROJECT_DIR=%~dp0"
if "%PROJECT_DIR:~-1%"=="\" set "PROJECT_DIR=%PROJECT_DIR:~0,-1%"
set "LINK_NAME=pemweb"
set "LINK_PATH=%XAMPP_DIR%\htdocs\%LINK_NAME%"
set "BASE_URL=http://localhost"

echo.
echo [i] XAMPP   : %XAMPP_DIR%
echo [i] Proyek  : %PROJECT_DIR%
echo [i] URL     : %BASE_URL%/%LINK_NAME%/
echo.

rem ---------- 1. Pastikan Apache berjalan ----------
tasklist /FI "IMAGENAME eq httpd.exe" 2>nul | find /I "httpd.exe" >nul
if errorlevel 1 (
    echo [i] Apache belum berjalan, menyalakan...
    start "XAMPP Apache" /min "%XAMPP_DIR%\apache\bin\httpd.exe"
    powershell -NoProfile -Command "for($i=0;$i -lt 30;$i++){ try { Invoke-WebRequest '%BASE_URL%/' -UseBasicParsing -TimeoutSec 2 | Out-Null; exit 0 } catch { Start-Sleep -Seconds 1 } }; exit 1"
    if errorlevel 1 (
        echo [X] Apache gagal dijalankan.
        echo     Cek apakah port 80 dipakai aplikasi lain, atau buka XAMPP Control Panel.
        echo.
        pause
        exit /b 1
    )
    echo [v] Apache aktif.
) else (
    echo [v] Apache sudah berjalan.
)

rem ---------- 2. Sambungkan folder proyek ke htdocs ----------
if exist "%LINK_PATH%\" (
    echo [v] Folder htdocs\%LINK_NAME% sudah tersedia.
) else (
    echo [i] Menyambungkan folder proyek ke htdocs\%LINK_NAME% ...
    mklink /J "%LINK_PATH%" "%PROJECT_DIR%" >nul
    if errorlevel 1 (
        echo [X] Gagal membuat junction.
        echo     Jalankan file ini sebagai Administrator, atau salin manual
        echo     folder proyek ke "%XAMPP_DIR%\htdocs\%LINK_NAME%".
        echo.
        pause
        exit /b 1
    )
    echo [v] Junction dibuat: %LINK_PATH%
)

rem ---------- 3. Buka browser ----------
echo [i] Membuka %BASE_URL%/%LINK_NAME%/ ...
start "" "%BASE_URL%/%LINK_NAME%/"

echo.
echo [v] Selesai. Tekan tombol apa saja untuk menutup jendela ini.
echo     Catatan: server PHP bawaan (start.bat) di port 8000 tidak terganggu.
pause >nul
endlocal
