<?php

Route::group(['middleware' => 'preventBackHistory'], function () {
    Route::get('password-reset', 'PasswordController@showForm');
    Route::post('password-reset', 'PasswordController@sendPasswordResetToken')->name('password-reset');
    Route::get('reset-password/{token}', 'PasswordController@showPasswordResetForm');
    Route::post('reset-password/', 'PasswordController@resetPassword')->name('reset-password');

    Auth::routes();

    Route::get('/', 'InicioController@frontend');

    Route::get('/limpiar', ['uses' => 'InicioController@limpiar', 'as' => 'limpiar']);

    Route::middleware(['auth'])->group(function () {

        Route::get('/home', ['uses' => 'InicioController@index', 'as' => 'home']);

        Route::resource('actualizacion', 'ActualizacionController', ['except' => ['create', 'store', 'update', 'show', 'edit']]);
        Route::post('actualizacion/destroy', ['uses' => 'ActualizacionController@destroy', 'as' => 'actualizacion.destroy']);
        Route::get('actualizacion/parametro', ['uses' => 'ActualizacionController@parametro', 'as' => 'actualizacion.parametro']);
        Route::post('actualizacion/buscar', ['uses' => 'ActualizacionController@buscar', 'as' => 'actualizacion.buscar']);
        Route::post('actualizacion/actualizar', ['uses' => 'ActualizacionController@actualizar', 'as' => 'actualizacion.actualizar']);
        Route::get('actualizacion/reversar/{id}', ['uses' => 'ActualizacionController@reversar', 'as' => 'actualizacion.reversar']);

        Route::resource('dolar', 'DolarController');

        Route::resource('cheque', 'ChequeController');
        Route::post('cheque/destroy', ['uses' => 'ChequeController@destroy', 'as' => 'cheque.destroy']);
        Route::post('cheque/update/{id}', ['uses' => 'ChequeController@update', 'as' => 'cheque.update']);
        Route::post('cheque/buscar', ['uses' => 'ChequeController@buscar', 'as' => 'cheque.buscar']);

        Route::get('producto/excel', ['uses' => 'ProductoController@excel', 'as' => 'producto.excel']);
        Route::get('producto/estadisticas/{producto?}', ['uses' => 'ProductoController@estadisticas', 'as' => 'producto.estadisticas']);
        Route::get('producto/{producto}/detalleestadistica', ['uses' => 'ProductoController@detalleestadistica', 'as' => 'producto.detalleestadistica']);

        Route::resource('producto', 'ProductoController');
        Route::post('producto/destroy', ['uses' => 'ProductoController@destroy', 'as' => 'producto.destroy']);
        Route::post('producto/asociarProv', ['uses' => 'ProductoController@asociarProv', 'as' => 'producto.asociarProv']);

        Route::get('rubro/data', ['uses' => 'RubroController@data', 'as' => 'rubro.data']);
        Route::resource('rubro', 'RubroController');
        Route::post('rubro/destroy', ['uses' => 'RubroController@destroy', 'as' => 'rubro.destroy']);
        Route::post('rubro/update', ['uses' => 'RubroController@update', 'as' => 'rubro.update']);

        Route::resource('marca', 'MarcaController');
        Route::post('marca/destroy', ['uses' => 'MarcaController@destroy', 'as' => 'marca.destroy']);

        Route::resource('compra', 'CompraController');
        Route::get('compra/edit/{id}', ['uses' => 'CompraController@edit', 'as' => 'compra.edit']);
        Route::post('compra/destroy', ['uses' => 'CompraController@destroy', 'as' => 'compra.destroy']);
        Route::post('compra/registrarCpra', ['uses' => 'CompraController@registrarCpra', 'as' => 'compra.registrarCpra']);
        Route::get('compra/{idproveedor}/compraProveedor', ['uses' => 'CompraController@compraProveedor', 'as' => 'compra.compraProveedor']);
        Route::get('compra/create/{id?}', ['uses' => 'CompraController@create', 'as' => 'compra.create']);

        Route::resource('contacto', 'ContactoController');
        Route::get('contacto/{contacto}/show', ['uses' => 'ContactoController@show', 'as' => 'contacto.show']);
        Route::post('contacto/destroy', ['uses' => 'ContactoController@destroy', 'as' => 'contacto.destroy']);
        Route::post('contacto/vendedor', ['uses' => 'ContactoController@vendedor', 'as' => 'contacto.vendedor']);
        Route::get('contacto/ctasctes/{contacto}', ['uses' => 'ContactoController@ctasctes', 'as' => 'contacto.ctasctes']);

        Route::resource('pago', 'PagoController');
        Route::post('pago/destroy', ['uses' => 'PagoController@destroy', 'as' => 'pago.destroy']);
        Route::get('pago/pagoProveedor/{id}', ['uses' => 'PagoController@pagoProveedor', 'as' => 'pago.pagoProveedor']);
        Route::get('pago/create/{id?}', ['uses' => 'PagoController@create', 'as' => 'pago.create']);
        Route::get('pago/anular/{id}', ['uses' => 'PagoController@anular', 'as' => 'pago.anular']);

        Route::resource('movproveedor', 'MovProveedorController');
        Route::get('movproveedor/{id}/index', ['uses' => 'MovProveedorController@index', 'as' => 'movproveedor.index']);
        Route::get('movproveedor/{id}/deuda', ['uses' => 'MovProveedorController@deuda', 'as' => 'movproveedor.deuda']);
        Route::post('movproveedor/destroy', ['uses' => 'MovProveedorController@destroy', 'as' => 'movproveedor.destroy']);

        Route::resource('proveedor', 'ProveedorController');
        Route::post('proveedor/destroy', ['uses' => 'ProveedorController@destroy', 'as' => 'proveedor.destroy']);

        Route::resource('pendiente', 'PendienteController');
        Route::post('pendiente/destroy', ['uses' => 'PendienteController@destroy', 'as' => 'pendiente.destroy']);

        Route::get('print/ordenPago/{id}', ['uses' => 'PrintController@printOrdenPago', 'as' => 'print.ordenPago']);
        Route::get('print/{id}/printCtaCte/{tipo}', ['uses' => 'PrintController@printCtaCte', 'as' => 'print.ctacte']);
        Route::get('print/{id}/printCtaCteDeuda/{idmax}', ['uses' => 'PrintController@printCtaCteDeuda', 'as' => 'print.ctactedeuda']);
        Route::get('print/{id}/printCtaCteFecha/{tipo}/{fechad}/{fechah}', ['uses' => 'PrintController@printCtaCteFecha', 'as' => 'print.ctactefecha']);
        Route::get('print/printComprobante/{idcomprobante}/{tipocomprobante}', ['uses' => 'PrintController@printComprobante', 'as' => 'print.comprobante']);
        Route::get('print/printPedido/{idcomprobante}', ['uses' => 'PrintController@printPedido', 'as' => 'print.pedido']);
        Route::get('print/printPresupuesto/{idcomprobante}', ['uses' => 'PrintController@printPresupuesto', 'as' => 'print.presupuesto']);
        Route::get('print/printPresupuestop/{idcomprobante}', ['uses' => 'PrintController@printPresupuestop', 'as' => 'print.presupuestop']);
        Route::get('print/printComprobanteProv/{idcomprobante}/{tipocomprobante}', ['uses' => 'PrintController@printComprobanteProv', 'as' => 'print.comprobanteprov']);
        Route::get('print/{idproveedor}/printProductoProveedor', ['uses' => 'PrintController@printProductoProveedor', 'as' => 'print.productoproveedor']);
        Route::get('print/printProductoMarcas/{marcas?}', ['uses' => 'PrintController@printProductoMarcas', 'as' => 'print.productomarcas']);
        Route::get('print/printProductoRubros/{rubros?}', ['uses' => 'PrintController@printProductoRubros', 'as' => 'print.productorubros']);
        Route::get('print/printProductos', ['uses' => 'PrintController@printProductos', 'as' => 'print.productolistado']);
        Route::get('print/printProductos/form', ['uses' => 'PrintController@printProductosForm', 'as' => 'print.productoForm']);

        Route::resource('pedido', 'PedidoController');
        Route::get('pedido/facturado/{id}', ['uses' => 'PedidoController@facturado', 'as' => 'pedido.facturado']);
        Route::post('pedido/destroy', ['uses' => 'PedidoController@destroy', 'as' => 'pedido.destroy']);
        Route::get('pedido/descartar/{id}', ['uses' => 'PedidoController@descartar', 'as' => 'pedido.descartar']);
        Route::get('pedido/edit/{id}', ['uses' => 'PedidoController@edit', 'as' => 'pedido.edit']);
        Route::post('pedido/update', ['uses' => 'PedidoController@update', 'as' => 'pedido.update']);

        Route::resource('presupuestop', 'PresupuestopController');
        Route::post('presupuestop/destroy', ['uses' => 'PresupuestopController@destroy', 'as' => 'presupuestop.destroy']);
        Route::get('presupuestop/descartar/{id}', ['uses' => 'PresupuestopController@descartar', 'as' => 'presupuestop.descartar']);
        Route::get('presupuestop/{presupuesto}/edit', ['uses' => 'PresupuestopController@edit', 'as' => 'presupuestop.edit']);

        Route::resource('presupuesto', 'PresupuestoController');
        Route::get('presupuesto/facturado/{id}', ['uses' => 'PresupuestoController@facturado', 'as' => 'presupuesto.facturado']);
        Route::post('presupuesto/destroy', ['uses' => 'PresupuestoController@destroy', 'as' => 'presupuesto.destroy']);
        Route::get('presupuesto/descartar/{id}', ['uses' => 'PresupuestoController@descartar', 'as' => 'presupuesto.descartar']);
        Route::get('presupuesto/{presupuesto}/edit', ['uses' => 'PresupuestoController@edit', 'as' => 'presupuesto.edit']);
        Route::post('presupuesto/update', ['uses' => 'PresupuestoController@update', 'as' => 'presupuesto.update']);
        Route::get('presupuesto/{presupuesto}/show', ['uses' => 'PresupuestoController@show', 'as' => 'presupuesto.show']);
        Route::get('presupuesto/{pendiente}/editPendiente/{producto}', ['uses' => 'PresupuestoController@editPendiente', 'as' => 'presupuesto.editPendiente']);
        Route::post('presupuesto/pendiente/chequed', ['uses' => 'PresupuestoController@pendienteChequed', 'as' => 'presupuesto.pendienteChequed']);

        Route::get('movcontacto/{id}/index', ['uses' => 'MovContactoController@index', 'as' => 'movcontacto.index']);
        Route::get('movcontacto/{id}/deuda', ['uses' => 'MovContactoController@deuda', 'as' => 'movcontacto.deuda']);
        Route::post('movcontacto/buscar', ['uses' => 'MovContactoController@buscar', 'as' => 'movcontacto.buscar']);
        Route::post('movcontacto/destroy', ['uses' => 'MovContactoController@destroy', 'as' => 'movcontacto.destroy']);

        // ORDEN PAGO
        Route::get('ordenpago/index/{id?}', ['uses' => 'OrdenController@index', 'as' => 'ordenpago.index']);
        Route::get('ordenpago/{id}/ordenpagoProveedor', ['uses' => 'OrdenController@ordenPagoProveedor', 'as' => 'ordenpago.pagoProveedor']);
        Route::get('ordenpago/create/{id?}', ['uses' => 'OrdenController@create', 'as' => 'ordenpago.create']);
        Route::post('ordenpago/store', ['uses' => 'OrdenController@store', 'as' => 'ordenpago.store']);
        Route::get('ordenpago/{id}/anular', ['uses' => 'OrdenController@anular', 'as' => 'ordenpago.anular']);
        Route::post('ordenpago/destroy', ['uses' => 'OrdenController@destroy', 'as' => 'ordenpago.destroy']);

        Route::resource('cobro', 'CobroController');
        Route::post('cobro/destroy', ['uses' => 'CobroController@destroy', 'as' => 'cobro.destroy']);
        Route::get('cobro/{idcontacto}/cobroContacto', ['uses' => 'CobroController@cobroContacto', 'as' => 'cobro.cobroContacto']);
        Route::get('cobro/{id}/create', ['uses' => 'CobroController@create', 'as' => 'cobro.create']);
        Route::post('cobro/buscar', ['uses' => 'CobroController@buscar', 'as' => 'cobro.buscar']);
        Route::get('cobro/{id}/anular', ['uses' => 'CobroController@anular', 'as' => 'cobro.anular']);

        Route::resource('venta', 'VentaController');
        Route::post('venta/destroy', ['uses' => 'VentaController@destroy', 'as' => 'venta.destroy']);
        Route::post('venta/registrarVta', ['uses' => 'VentaController@registrarVta', 'as' => 'venta.registrarVta']);
        Route::post('venta/registrarVtaP', ['uses' => 'VentaController@registrarVtaP', 'as' => 'venta.registrarVtaP']);
        Route::post('venta/registrarVtaManual', ['uses' => 'VentaController@registrarVtaManual', 'as' => 'venta.registrarVtaManual']);
        Route::get('venta/{idcontacto}/ventaContacto', ['uses' => 'VentaController@ventaContacto', 'as' => 'venta.ventaContacto']);
        Route::post('venta/buscar', ['uses' => 'VentaController@buscar', 'as' => 'venta.buscar']);
        Route::get('venta/create/{id?}', ['uses' => 'VentaController@create', 'as' => 'venta.create']);

        Route::get('change-password', ['uses' => 'UpdatePasswordController@index', 'as' => 'password.form']);
        Route::post('change-password', ['uses' => 'UpdatePasswordController@update', 'as' => 'password.update']);

        //////////  DETALLE DE PEDIDOS
        Route::resource('detallepedido', 'DetallePedidoController');
        Route::post('detallepedido/pedido', ['uses' => 'DetallePedidoController@pedido', 'as' => 'detallepedido.pedido']);
        Route::post('detallepedido/pendiente', ['uses' => 'DetallePedidoController@pendiente', 'as' => 'detallepedido.pendiente']);
        Route::post('detallepedido/insert', ['uses' => 'DetallePedidoController@insert', 'as' => 'detallepedido.insert']);
        Route::post('detallepedido/destroy', ['uses' => 'DetallePedidoController@destroy', 'as' => 'detallepedido.destroy']);
        Route::post('detallepedido/update', ['uses' => 'DetallePedidoController@update', 'as' => 'detallepedido.update']);
        Route::get('detallepedido/{id}/detalle', ['uses' => 'DetallePedidoController@index', 'as' => 'detallepedido.index']);
        Route::get('detallepedido/{id?}/show', ['uses' => 'DetallePedidoController@show', 'as' => 'detallepedido.show']);
        Route::get('detallepedido/{id?}/edit', ['uses' => 'DetallePedidoController@edit', 'as' => 'detallepedido.edit']);
        Route::get('detallepedido/{id}/facturacion', ['uses' => 'DetallePedidoController@facturacion', 'as' => 'detallepedido.facturacion']);

        //////////  DETALLE DE PRESUPUESTOS
        Route::resource('detallepresupuesto', 'DetallePresupuestoController');
        Route::post('detallepresupuesto/pedido', ['uses' => 'DetallePresupuestoController@pedido', 'as' => 'detallepresupuesto.pedido']);
        Route::post('detallepresupuesto/pendiente', ['uses' => 'DetallePresupuestoController@pendiente', 'as' => 'detallepresupuesto.pendiente']);
        Route::post('detallepresupuesto/insert', ['uses' => 'DetallePresupuestoController@insert', 'as' => 'detallepresupuesto.insert']);
        Route::post('detallepresupuesto/destroy', ['uses' => 'DetallePresupuestoController@destroy', 'as' => 'detallepresupuesto.destroy']);
        Route::post('detallepresupuesto/update', ['uses' => 'DetallePresupuestoController@update', 'as' => 'detallepresupuesto.update']);
        Route::get('detallepresupuesto/{id}/detalle', ['uses' => 'DetallePresupuestoController@index', 'as' => 'detallepresupuesto.index']);
        Route::get('detallepresupuesto/{id?}/show', ['uses' => 'DetallePresupuestoController@show', 'as' => 'detallepresupuesto.show']);
        Route::get('detallepresupuesto/{id}/facturacion', ['uses' => 'DetallePresupuestoController@facturacion', 'as' => 'detallepresupuesto.facturacion']);

        //////////  DETALLE DE PRESUPUESTOS PROVEEDORES
        Route::resource('detallepresupuestop', 'DetallePresupuestopController');
        Route::post('detallepresupuestop/pedido', ['uses' => 'DetallePresupuestopController@pedido', 'as' => 'detallepresupuestop.pedido']);
        Route::post('detallepresupuestop/pendiente', ['uses' => 'DetallePresupuestopController@pendiente', 'as' => 'detallepresupuestop.pendiente']);
        Route::post('detallepresupuestop/insert', ['uses' => 'DetallePresupuestopController@insert', 'as' => 'detallepresupuestop.insert']);
        Route::post('detallepresupuestop/destroy', ['uses' => 'DetallePresupuestopController@destroy', 'as' => 'detallepresupuestop.destroy']);
        Route::post('detallepresupuestop/update', ['uses' => 'DetallePresupuestopController@update', 'as' => 'detallepresupuestop.update']);
        Route::get('detallepresupuestop/{id}/detalle', ['uses' => 'DetallePresupuestopController@index', 'as' => 'detallepresupuestop.index']);
        Route::get('detallepresupuestop/{id?}/show', ['uses' => 'DetallePresupuestopController@show', 'as' => 'detallepresupuestop.show']);
        Route::get('detallepresupuestop/{id}/facturacion', ['uses' => 'DetallePresupuestopController@facturacion', 'as' => 'detallepresupuestop.facturacion']);

        //////////  DETALLE DE PAGOS
        Route::resource('detallepago', 'DetallePagoController');
        Route::get('detallepago/{id}/index', ['uses' => 'DetallePagoController@index', 'as' => 'detallepago.index']);
        Route::get('detallepago/{id}/show', ['uses' => 'DetallePagoController@show', 'as' => 'detallepago.show']);
        Route::post('detallepago/cerrar', ['uses' => 'DetallePagoController@cerrar', 'as' => 'detallepago.cerrar']);
        Route::post('detallepago/autorizacion', ['uses' => 'DetallePagoController@autorizacion', 'as' => 'detallepago.autorizacion']);
        Route::post('detallepago/insert', ['uses' => 'DetallePagoController@insert', 'as' => 'detallepago.insert']);
        Route::post('detallepago/destroy', ['uses' => 'DetallePagoController@destroy', 'as' => 'detallepago.destroy']);
        Route::post('detallepago/insertc', ['uses' => 'DetallePagoController@insertc', 'as' => 'detallepago.insertc']);
        Route::post('detallepago/destroyc', ['uses' => 'DetallePagoController@destroyc', 'as' => 'detallepago.destroyc']);

        //////////  DETALLE ORDEN DE PAGOS
        Route::get('detalleordenpago/{id}/index', ['uses' => 'DetalleOrdenPagoController@index', 'as' => 'detalleordenpago.index']);
        Route::post('detalleordenpago/autorizacion', ['uses' => 'DetalleOrdenPagoController@autorizacion', 'as' => 'detalleordenpago.autorizacion']);

        //////////  DETALLE DE COBROS
        Route::resource('detallecobro', 'DetalleCobroController');
        Route::get('detallecobro/{id}/index', ['uses' => 'DetalleCobroController@index', 'as' => 'detallecobro.index']);
        Route::get('detallecobro/{id}/show', ['uses' => 'DetalleCobroController@show', 'as' => 'detallecobro.show']);
        Route::post('detallecobro/cerrar', ['uses' => 'DetalleCobroController@cerrar', 'as' => 'detallecobro.cerrar']);
        Route::post('detallecobro/imputacion', ['uses' => 'DetalleCobroController@imputacion', 'as' => 'detallecobro.imputacion']);
        Route::post('detallecobro/insert', ['uses' => 'DetalleCobroController@insert', 'as' => 'detallecobro.insert']);
        Route::post('detallecobro/insertc', ['uses' => 'DetalleCobroController@insertc', 'as' => 'detallecobro.insertc']);
        Route::post('detallecobro/destroy', ['uses' => 'DetalleCobroController@destroy', 'as' => 'detallecobro.destroy']);
        Route::post('detallecobro/destroyc', ['uses' => 'DetalleCobroController@destroyc', 'as' => 'detallecobro.destroyc']);
        Route::post('detallecobro/asociarVenta', ['uses' => 'DetalleCobroController@asociarVenta', 'as' => 'detallecobro.asociarVenta']);
        Route::post('detallecobro/borrarefectivo', ['uses => DetalleCobroController@borrarefectivo', 'as' => 'detallecobro.borrarEfectivo']);

        //////////  DETALLE DE COMPRAS
        Route::resource('detallecompra', 'DetalleCompraController');
        Route::post('detallecompra/destroy', ['uses' => 'DetalleCompraController@destroy', 'as' => 'detallecompra.destroy']);
        Route::post('detallecompra/insert', ['uses' => 'DetalleCompraController@insert', 'as' => 'detallecompra.insert']);
        Route::post('detallecompra/getproducto', ['uses' => 'DetalleCompraController@getproducto', 'as' => 'detallecompra.getproducto']);
        Route::get('detallecompra/{id}/index', ['uses' => 'DetalleCompraController@index', 'as' => 'detallecompra.index']);
        Route::get('detallecompra/{id}/show', ['uses' => 'DetalleCompraController@show', 'as' => 'detallecompra.show']);

        //////////  DETALLE DE VENTAS
        Route::resource('detalleventa', 'DetalleVentaController');
        Route::post('detalleventa/destroy', ['uses' => 'DetalleVentaController@destroy', 'as' => 'detalleventa.destroy']);
        Route::post('detalleventa/insert', ['uses' => 'DetalleVentaController@insert', 'as' => 'detalleventa.insert']);
        Route::post('detalleventa/getproducto', ['uses' => 'DetalleVentaController@getproducto', 'as' => 'detalleventa.getproducto']);
        Route::get('detalleventa/{id}/index', ['uses' => 'DetalleVentaController@index', 'as' => 'detalleventa.index']);
        Route::get('detalleventa/{id}/show', ['uses' => 'DetalleVentaController@show', 'as' => 'detalleventa.show']);

        //////////  USUARIOS
        Route::get('users', ['uses' => 'UsersController@index', 'as' => 'users.index'])->middleware('permission:users.index');

        Route::get('users/dataindex', ['uses' => 'UsersController@dataindex', 'as' => 'users.dataindex']);
        Route::get('users/data', ['uses' => 'UsersController@usersData', 'as' => 'users.data']);

        Route::get('users/create', ['uses' => 'UsersController@create', 'as' => 'users.create'])->middleware('permission:users.create');
        Route::post('users/store', ['uses' => 'UsersController@store', 'as' => 'users.store'])->middleware('permission:users.create');
        Route::get('users/{user}/edit', ['uses' => 'UsersController@edit', 'as' => 'users.edit'])->middleware('permission:users.edit');
        Route::put('users/{user}/update', ['uses' => 'UsersController@update', 'as' => 'users.update'])->middleware('permission:users.edit');
        Route::post('users/destroy', ['uses' => 'UsersController@destroy', 'as' => 'users.destroy'])->middleware('permission:users.destroy');

        Route::get('users/{id}/editprofile', ['uses' => 'UsersController@editProfile', 'as' => 'users.editprofile']);
        Route::post('users/updateprofile', ['uses' => 'UsersController@updateProfile', 'as' => 'users.updateprofile']);
        Route::post('users/buscar', ['uses' => 'UsersController@buscar', 'as' => 'users.buscar']);

        //////////  ROLES
        Route::get('roles', 'RoleController@index')->name('roles.index')->middleware('permission:roles.index');
        Route::get('roles/create', 'RoleController@create')->name('roles.create')->middleware('permission:roles.create');
        Route::post('roles/store', 'RoleController@store')->name('roles.store')->middleware('permission:roles.create');
        Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit')->middleware('permission:roles.edit');
        Route::put('roles/{role}', 'RoleController@update')->name('roles.update')->middleware('permission:roles.edit');
        Route::post('roles/destroy', 'RoleController@destroy')->name('roles.destroy')->middleware('permission:roles.destroy');
    });
});
