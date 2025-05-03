@echo off
setlocal


cd /c C:\PROJECT\WEBSITE\rfid-absensi

for /f "tokens=2 delims=:" %%I in ('ipconfig ^| findstr /i "IPv4"') do set IP=%%I
set IP=%IP: =%

"C:\laragon\bin\php\php-8.3.13-Win32-vs16-x64\php.exe" -S %IP%:8000 -t public

pause