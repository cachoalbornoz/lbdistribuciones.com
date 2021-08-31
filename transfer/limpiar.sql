DROP TRIGGER ADPago;
DROP TRIGGER AIContacto;
DROP TRIGGER AIPago;
DROP TRIGGER AIVenta;
DROP TRIGGER BDDetalleVenta;
DROP TRIGGER BDVenta;
DROP TRIGGER BIDetalleVenta;

delete from detalle_pedido;
delete from pedido;  
delete from detalle_pago;
delete from pago; 

delete from detalle_venta_copy;
delete from venta_copy;  
delete from detalle_pago_copy;
delete from pago_copy; 


