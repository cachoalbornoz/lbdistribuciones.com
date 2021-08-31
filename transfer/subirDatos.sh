#!/bin/bash
clear
echo 'Generando copias VENTAS y PAGOS, aguarde por favor ...'
echo ' '
cd /opt/lampp/bin
./mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < /opt/lampp/htdocs/lbdistrib/src/Transfer/copia.sql
echo 'Subiendo al servidor http://www.lbdistribuciones.com --p 65002. Aguarde por favor ...'
echo ' '
./mysqldump --user=u621638053_lbdis --password=cervantes69 --no-create-db --no-create-info --skip-add-drop-table --skip-add-locks --skip-disable-keys --skip-set-charset --skip-triggers u621638053_lbdis venta_copy detalle_venta_copy pago_copy detalle_pago_copy > /opt/lampp/htdocs/lbdistrib/src/backUp/$(date +%Y-%m-%d-%H.%M.%S).sql
./mysqldump --user=u621638053_lbdis --password=cervantes69 --no-create-db --no-create-info --skip-add-drop-table --skip-add-locks --skip-disable-keys --skip-set-charset --skip-triggers u621638053_lbdis venta_copy detalle_venta_copy pago_copy detalle_pago_copy > /opt/lampp/htdocs/lbdistrib/src/backUp/backup.sql
echo ' '
scp -P '65002' /opt/lampp/htdocs/lbdistrib/src/backUp/backup.sql u621638053@31.220.16.221:public_html/src/backUp/backup.sql
echo ' '
ssh -l u621638053 -p 65002 31.220.16.221 './public_html/src/Transfer/exportar.sh'
echo ' '
echo 'Limpiando datos locales ...'
./mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < /opt/lampp/htdocs/lbdistrib/src/Transfer/limpiar.sql
./mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < /opt/lampp/htdocs/lbdistrib/src/Transfer/triggers.sql
echo ' '
echo 'Fin de la transmisión ...'

