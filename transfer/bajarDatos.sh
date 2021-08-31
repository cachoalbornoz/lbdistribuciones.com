#!/bin/bash
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
echo 'Syncronización finalizada '
echo ' '


