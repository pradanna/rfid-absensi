@echo off
for /f "tokens=2 delims=:" %%I in ('ipconfig ^| findstr /i "IPv4"') do set IP=%%I
set IP=%IP: =%

php -S %IP%:8000 -t public
pause
