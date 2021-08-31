#!/bin/bash
clear
echo 'Accediendo al servidor http://www.lbdistribuciones.com --p 65002'
ssh -l u621638053 -p 65002 31.220.16.221 './exportar.sh'
echo 'Generando BackUp de Tablas Productos, Pagos '
scp -r -P 65002 u621638053@31.220.16.221:public_html/src/backUp/ /home/guillermo
cd /opt/lampp/bin
./mysql -u root -pcervantes u621638053_lbdis < /home/guillermo/backUp/producto.sql
./mysql -u root -pcervantes u621638053_lbdis < /home/guillermo/backUp/contacto.sql
clear
echo 'Copia archivos LB Representaciones finalizada '


