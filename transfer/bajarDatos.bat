@echo off
cls
echo "Inicia la Sincronizacion de archivos ... aguarde por favor 
cls
"C:\Program Files\FreeFileSync\FreeFileSync.exe" LB_BajarDatos.ffs_batch
if errorlevel 1 (
  ::if return code is 1 or greater, something went wrong, add special treatment here
  echo No se pudo sincronizar ... Revise la conexion 
  pause
)

cls
cd C:\xampp\mysql\bin
echo Descargando Base Datos desde servidor http://www.lbdistribuciones.com --p 65002. Aguarde por favor ...
ssh -l u621638053 -p 65002 31.220.16.221 "mysqldump --user=u621638053_lbdis --password=cervantes69 u621638053_lbdis producto contacto marca rubro sub_rubro saldo_contacto mov_contacto" | mysql -u root -pcervantes u621638053_lbdis
echo .
echo ..
echo ...
echo La Base de Datos se actualizo correctamente 



