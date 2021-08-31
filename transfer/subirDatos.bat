@echo off
cls
echo Generando copias VENTAS y PAGOS, aguarde por favor ...
echo .
cd C:\xampp\mysql\bin
mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < C:\xampp\htdocs\lbdistrib\src\Transfer\copia.sql
echo Subiendo al servidor https://www.lbdistribuciones.com --p 65002. Aguarde por favor ...
echo.
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /format:list') do set datetime=%%I
set datetime=%datetime:~0,4%-%datetime:~4,2%-%datetime:~6,2%_%datetime:~8,2%-%datetime:~10,2%-%datetime:~12,2%
mysqldump -u root -pcervantes --no-create-db --no-create-info --skip-add-drop-table --skip-opt --skip-add-locks --skip-disable-keys --skip-set-charset --skip-triggers u621638053_lbdis venta_copy detalle_venta_copy pago_copy detalle_pago_copy  > C:\xampp\htdocs\lbdistrib\src\backUp\backup__%datetime%.sql
mysqldump -u root -pcervantes --no-create-db --no-create-info --skip-add-drop-table --skip-opt --skip-add-locks --skip-disable-keys --skip-set-charset --skip-triggers u621638053_lbdis venta_copy detalle_venta_copy pago_copy detalle_pago_copy  > C:\xampp\htdocs\lbdistrib\src\backUp\backup.sql
echo.
scp -P 65002 \xampp\htdocs\lbdistrib\src\backUp\backup.sql u621638053@31.220.16.221:public_html/src/backUp/backup.sql
echo.
ssh -l u621638053 -p 65002 31.220.16.221 './public_html/src/Transfer/exportar.sh'
echo.
echo Limpiando datos locales ...
mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < C:\xampp\htdocs\lbdistrib\src\Transfer\limpiar.sql
mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < C:\xampp\htdocs\lbdistrib\src\Transfer\triggers.sql
echo.
echo Fin de la transmisión ...
echo.
echo.


