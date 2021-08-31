#!/bin/bash
clear
cd /opt/lampp/bin
echo 'Subiendo al servidor http://www.lbdistribuciones.com --p 65002. Aguarde por favor ...'
echo ' '
./mysqldump -u root -pcervantes --no-create-db --no-create-info --skip-add-drop-table --skip-add-locks --skip-disable-keys --skip-set-charset --skip-triggers u621638053_lbdis venta detalle_venta pago detalle_pago | sed -e "s/([0-9]*,/(NULL,/gi" > /opt/lampp/htdocs/lbdistrib/src/backUp/$(date +%Y-%m-%d-%H.%M.%S).sql
./mysqldump -u root -pcervantes --no-create-db --no-create-info --skip-add-drop-table --skip-add-locks --skip-disable-keys --skip-set-charset --skip-triggers u621638053_lbdis venta detalle_venta pago detalle_pago | sed -e "s/([0-9]*,/(NULL,/gi" > /opt/lampp/htdocs/lbdistrib/src/backUp/backup.sql
echo ' '
scp -P '65002' /opt/lampp/htdocs/lbdistrib/src/backUp/backup.sql u621638053@31.220.16.221:public_html/src/backUp/backup.sql
echo ' '
ssh -l u621638053 -p 65002 31.220.16.221 './public_html/src/Transfer/exportar.sh'
echo ' '
echo 'Transmitiendo datos ...'
./mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < /opt/lampp/htdocs/lbdistrib/src/Transfer/limpiar.sql
./mysql --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis < /opt/lampp/htdocs/lbdistrib/src/Transfer/triggers.sql
echo ' '
echo 'Fin subida de datos ...'
clear
cd /opt/lampp/bin
echo 'Descargando Base Datos desde servidor http://www.lbdistribuciones.com --p 65002. Aguarde por favor ...'
ssh -l u621638053 -p 65002 31.220.16.221 "mysqldump --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis producto contacto marca rubro sub_rubro saldo_contacto mov_contacto | gzip -c" | gunzip | ./mysql -u root -pcervantes u621638053_lbdis
echo ' '
echo 'Sincronizando imagenes de productos nuevos  ...'
rsync -r -a -v -e "ssh -p65002" u621638053@31.220.16.221:"public_html/web/images/upload/" "/opt/lampp/htdocs/lbdistrib/web/images/upload/"
echo ' '
echo 'Sincronizando marcas ...'
rsync -r -a -v -e "ssh -p65002" u621638053@31.220.16.221:"public_html/web/uploads/marcas/" "/opt/lampp/htdocs/lbdistrib/web/uploads/marcas/"
echo ' '
echo 'Fin bajada datos ...'
echo ' '
