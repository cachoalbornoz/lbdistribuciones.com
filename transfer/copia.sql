UPDATE pedido SET sucursal = 1 WHERE 1;
UPDATE detalle_pedido SET sucursal = 1 WHERE 1;
UPDATE pago SET sucursal = 1 WHERE 1;
UPDATE detalle_pago SET sucursal = 1 WHERE 1;

INSERT INTO venta_copy SELECT * from pedido; 
INSERT INTO detalle_venta_copy SELECT * from detalle_pedido; 
INSERT INTO pago_copy SELECT * from pago; 
INSERT INTO detalle_pago_copy SELECT * from detalle_pago;