-- --------------------------------------------------------
-- Host:                         sql33.main-hosting.eu
-- Versión del servidor:         10.1.30-MariaDB - MariaDB Server
-- SO del servidor:              Linux
-- HeidiSQL Versión:             9.5.0.5225
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para disparador u621638053_lbdis.ADPago
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `ADPago` AFTER DELETE ON `pago` FOR EACH ROW BEGIN
	DECLARE saldo decimal(10,2) default 0;    
    SET @saldo := (SELECT saldo_contacto.saldo FROM saldo_contacto WHERE saldo_contacto.contacto = OLD.contacto);
    SET @saldo := @saldo + OLD.total;
	INSERT INTO mov_contacto (`fecha`, `contacto`, `concepto`, `tipocomprobante`, `nro`, `debe`, `haber`, `saldo`) VALUES (OLD.fecha, OLD.contacto, 'Anulac Pago',OLD.tipocomprobante, OLD.nro, OLD.total, 0, @saldo);
   	UPDATE saldo_contacto SET saldo = @saldo where saldo_contacto.contacto = OLD.contacto;    
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador u621638053_lbdis.AIContacto
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `AIContacto` AFTER INSERT ON `contacto` FOR EACH ROW BEGIN
    INSERT INTO mov_contacto (`fecha`, `contacto`, `concepto`, `tipocomprobante`, `nro`, `debe`, `haber`, `saldo`) VALUES (NOW(), NEW.ID, 'Apertura Cta Cte', 10, 0, 0, 0, 0);
    INSERT INTO saldo_contacto (`contacto`, `saldo`) VALUES (NEW.ID, 0);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador u621638053_lbdis.AIPago
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `AIPago` AFTER INSERT ON `pago` FOR EACH ROW BEGIN
	DECLARE saldo decimal(10,2) default 0;    
    SET @saldo := (SELECT saldo_contacto.saldo FROM saldo_contacto WHERE saldo_contacto.contacto = NEW.contacto) ;    
    SET @saldo := @saldo - NEW.total ;    
	INSERT INTO mov_contacto (`fecha`, `contacto`, `concepto`, `tipocomprobante`, `nro`, `debe`, `haber`, `saldo`) VALUES (NEW.fecha, NEW.contacto, 'Pago ', NEW.tipocomprobante, NEW.nro, 0, NEW.total, @saldo);
   	UPDATE saldo_contacto SET saldo = @saldo where saldo_contacto.contacto = NEW.contacto;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador u621638053_lbdis.AIVenta
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `AIVenta` AFTER INSERT ON `venta` FOR EACH ROW BEGIN
	DECLARE saldo decimal(10,2) default 0;    
    SET @saldo := (SELECT saldo_contacto.saldo FROM saldo_contacto WHERE saldo_contacto.contacto = NEW.contacto) ;    
    SET @saldo := @saldo + NEW.total ;    
	INSERT INTO mov_contacto (`fecha`, `contacto`, `concepto`, `tipocomprobante`, `nro`, `debe`, `haber`, `saldo`) VALUES (NEW.fecha, NEW.contacto, 'Compra',NEW.tipocomprobante, NEW.nro, NEW.total, 0, @saldo);
   	UPDATE saldo_contacto SET saldo = @saldo where saldo_contacto.contacto = NEW.contacto;    
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador u621638053_lbdis.BDDetalleVenta
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `BDDetalleVenta` BEFORE DELETE ON `detalle_venta` FOR EACH ROW UPDATE producto

SET producto.stockActual = producto.stockActual + OLD.cantidad WHERE producto.id = OLD.producto//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador u621638053_lbdis.BDVenta
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `BDVenta` BEFORE DELETE ON `venta` FOR EACH ROW BEGIN
	DECLARE saldo decimal(10,2) default 0;
    
    SET @saldo := (SELECT saldo_contacto.saldo FROM saldo_contacto WHERE saldo_contacto.contacto = OLD.contacto) ;
    
    SET @saldo := @saldo - OLD.total ;
    
	INSERT INTO mov_contacto (`fecha`, `contacto`, `concepto`, `tipocomprobante`, `nro`, `debe`, `haber`, `saldo`) VALUES (OLD.fecha, OLD.contacto, 'Anulac Compra',OLD.tipocomprobante, OLD.nro, 0, OLD.total, @saldo);
   	UPDATE saldo_contacto SET saldo = @saldo where saldo_contacto.contacto = OLD.contacto;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador u621638053_lbdis.BIDetalleVenta
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `BIDetalleVenta` BEFORE INSERT ON `detalle_venta` FOR EACH ROW UPDATE producto

SET producto.stockActual = producto.stockActual - NEW.cantidad WHERE producto.id = NEW.producto//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
