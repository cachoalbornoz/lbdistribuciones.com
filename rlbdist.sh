#!/bin/bash
cd /
cd home/guillermo/Dropbox/LBDistribuciones/
clear
echo 'Respaldando y comprimiendo Base Datos, aguarde por favor ...'
sshpass -p "Cervantes69"  ssh -l u621638053 -p 65002 141.136.43.1 "mysqldump --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis | gzip > u621638053_lbdis.sql.gz"
echo 'Copiando Base Datos desde servidor ... '
sshpass -p "Cervantes69" scp -P '65002' u621638053@141.136.43.1:u621638053_lbdis.sql.gz /home/guillermo/Dropbox/LBDistribuciones/
echo 'Borrando respaldo del servidor '
sshpass -p "Cervantes69"  ssh -l u621638053 -p 65002 141.136.43.1 "rm u621638053_lbdis.sql.gz"
echo 'Descomprimiendo ... '
rm u621638053_lbdis.sql
gunzip u621638053_lbdis.sql.gz
echo "LB Distribuciones iniciando restauracion, aguarde por favor ..."
mysql -h localhost -u root -pcervantes -e "DROP DATABASE IF EXISTS u621638053_lbdis ;"
mysql -h localhost -u root -pcervantes -e "CREATE DATABASE u621638053_lbdis CHARACTER SET utf8 COLLATE utf8_general_ci ;"
mysql -h localhost -u root -pcervantes u621638053_lbdis < u621638053_lbdis.sql;
echo "LB Distribuciones restaurada correctamente ...  "
