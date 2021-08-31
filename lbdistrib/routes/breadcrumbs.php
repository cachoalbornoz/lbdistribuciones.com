<?php

Breadcrumbs::for('inicio', function ($trail) {
    $trail->push('Inicio', route('home'));
});

// DOLAR
Breadcrumbs::for('dolar.edit', function ($trail, $dolar) {
    $trail->push($dolar->id);
    $trail->push('Actualizar', route('dolar.edit', $dolar->id));
});


//// ROLES
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Roles', route('roles.index'));
});

Breadcrumbs::for('roles.create', function ($trail) {
    $trail->parent('roles');
    $trail->push('Crear', route('roles.create'));
});

Breadcrumbs::for('roles.edit', function ($trail, $role) {
    $trail->parent('roles');
    $trail->push($role->id);
    $trail->push('Editar', route('roles.edit', $role->id));
});

//// ACTUALIZACIONES
Breadcrumbs::for('actualizacion', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Actualizacion', route('actualizacion.index'));
});

Breadcrumbs::for('actualizacion.parametro', function ($trail) {
    $trail->parent('actualizacion');
    $trail->push('Parametros', route('actualizacion.parametro'));
});

//// CHEQUES
Breadcrumbs::for('cheque', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Cheques', route('cheque.index'));
});

Breadcrumbs::for('cheque.create', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Crear', route('cheque.create'));
});

Breadcrumbs::for('cheque.edit', function ($trail, $cheque) {
    $trail->parent('cheque');
    $trail->push($cheque->id);
    $trail->push('Editar', route('cheque.edit', $cheque->id));
});

//// PRODUCTOS
Breadcrumbs::for('producto', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Productos', route('producto.index'));
});

Breadcrumbs::for('producto.create', function ($trail) {
    $trail->parent('producto');
    $trail->push('Crear', route('producto.create'));
});

Breadcrumbs::for('producto.edit', function ($trail, $producto) {
    $trail->parent('producto');
    $trail->push($producto->id);
    $trail->push('Editar', route('producto.edit', $producto->id));
});

//// RUBROS
Breadcrumbs::for('rubro', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Rubros', route('rubro.index'));
});

//// USUARIOS
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Usuarios', route('users.index'));
});

Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users');
    $trail->push('Crear', route('users.create'));
});

Breadcrumbs::for('users.edit', function ($trail, $users) {
    $trail->parent('users');
    $trail->push($users->id);
    $trail->push('Editar', route('users.edit', $users->id));
});


//// MARCAS
Breadcrumbs::for('marca', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Marcas', route('marca.index'));
});

Breadcrumbs::for('marca.create', function ($trail) {
    $trail->parent('marca');
    $trail->push('Crear', route('marca.create'));
});

Breadcrumbs::for('marca.edit', function ($trail, $marca) {
    $trail->parent('marca');
    $trail->push($marca->id);
    $trail->push('Editar', route('marca.edit', $marca->id));
});


//// CONTACTOS
Breadcrumbs::for('contacto', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Clientes', route('contacto.index'));
});

Breadcrumbs::for('contacto.create', function ($trail) {
    $trail->parent('contacto');
    $trail->push('Crear', route('contacto.create'));
});

Breadcrumbs::for('contacto.edit', function ($trail, $contacto) {
    $trail->parent('contacto');
    $trail->push($contacto->id);
    $trail->push('Editar', route('contacto.edit', $contacto->id));
});

Breadcrumbs::for('contacto.show', function ($trail, $contacto) {
    $trail->parent('contacto');
    $trail->push($contacto->nombreempresa);
    $trail->push('Mostrar', route('contacto.show', $contacto->id));
});

Breadcrumbs::for('contacto.movcontacto', function ($trail, $contacto) {
    $trail->parent('contacto');
    $trail->push($contacto->nombreempresa);
    $trail->push('Movimientos', route('movcontacto.index', $contacto->id));
});

Breadcrumbs::for('contacto.deuda', function ($trail, $contacto) {
    $trail->parent('contacto');
    $trail->push($contacto->nombreempresa);
    $trail->push('Deuda actual', route('movcontacto.index', $contacto->id));
});


// PEDIDOS
Breadcrumbs::for('pedido', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Pedidos', route('pedido.index'));
});

Breadcrumbs::for('pedido.create', function ($trail) {
    $trail->parent('pedido');
    $trail->push('Crear', route('pedido.create'));
});

Breadcrumbs::for('pedido.detalle', function ($trail, $pedido) {
    $trail->parent('pedido');
    $trail->push($pedido->id);
    $trail->push('Detalle pedido', route('detallepedido.index', $pedido->id));
});

Breadcrumbs::for('pedido.facturacion', function ($trail, $pedido) {
    $trail->parent('pedido');
    $trail->push($pedido->id);
    $trail->push('Facturacion - existencias ', route('detallepedido.facturacion', $pedido->id));
});

// PRESUPUESTOS
Breadcrumbs::for('presupuesto', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Presupuestos', route('presupuesto.index'));
});

Breadcrumbs::for('presupuesto.create', function ($trail) {
    $trail->parent('presupuesto');
    $trail->push('Crear', route('presupuesto.create'));
});

Breadcrumbs::for('presupuesto.detalle', function ($trail, $presupuesto) {
    $trail->parent('presupuesto');
    $trail->push($presupuesto->id);
    $trail->push('Detalle presupuesto', route('detallepresupuesto.index', $presupuesto->id));
});

Breadcrumbs::for('presupuesto.facturacion', function ($trail, $presupuesto) {
    $trail->parent('presupuesto');
    $trail->push($presupuesto->id);
    $trail->push('Facturacion - existencias ', route('detallepresupuesto.facturacion', $presupuesto->id));
});
    

// PRESUPUESTOS PROVEEDORES
Breadcrumbs::for('presupuestop', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Presupuestos', route('presupuestop.index'));
});

Breadcrumbs::for('presupuestop.create', function ($trail) {
    $trail->parent('presupuestop');
    $trail->push('Crear', route('presupuestop.create'));
});

Breadcrumbs::for('presupuestop.detalle', function ($trail, $presupuesto) {
    $trail->parent('presupuestop');
    $trail->push($presupuesto->id);
    $trail->push('Detalle presupuesto', route('detallepresupuestop.index', $presupuesto->id));
});

//// COMPRAS
Breadcrumbs::for('compra', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Compras', route('compra.index'));
});

Breadcrumbs::for('compra.create', function ($trail) {
    $trail->parent('compra');
    $trail->push('Crear', route('compra.create'));
});

Breadcrumbs::for('compra.detalle', function ($trail, $compra) {
    $trail->parent('compra');
    $trail->push($compra->id);
    $trail->push('Detalle compra', route('detallecompra.index', $compra->id));
});

Breadcrumbs::for('compra.proveedor', function ($trail, $proveedor) {
    $trail->parent('proveedor');
    $trail->push($proveedor->id);
    $trail->push('Compras', route('compra.compraProveedor', $proveedor->id));
});

//// VENTAS
Breadcrumbs::for('venta', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Ventas', route('venta.index'));
});

Breadcrumbs::for('venta.create', function ($trail) {
    $trail->parent('venta');
    $trail->push('Crear', route('venta.create'));
});

Breadcrumbs::for('venta.detalle', function ($trail, $venta) {
    $trail->parent('venta');
    $trail->push($venta->nro);
    $trail->push('Detalle venta', route('detalleventa.index', $venta->nro));
});

Breadcrumbs::for('venta.contacto', function ($trail, $contacto) {
    $trail->parent('contacto');
    $trail->push($contacto->nombreempresa);
    $trail->push('Ventas', route('venta.ventaContacto', $contacto->id));
});

//// COBROS
Breadcrumbs::for('cobro', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Cobro', route('cobro.index'));
});

Breadcrumbs::for('cobro.create', function ($trail) {
    $trail->parent('cobro');
    $trail->push('Crear', route('cobro.create'));
});

Breadcrumbs::for('cobro.detalle', function ($trail, $cobro) {
    $trail->parent('cobro');
    $trail->push($cobro->nro);
    $trail->push('Detalle cobro', route('detallecobro.index', $cobro->nro));
});

Breadcrumbs::for('cobro.contacto', function ($trail, $contacto) {
    $trail->parent('contacto');
    $trail->push($contacto->nombreempresa);
    $trail->push('Cobros', route('cobro.cobroContacto', $contacto->id));
});

//// PENDIENTES
Breadcrumbs::for('pendiente', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Pendientes', route('pendiente.index'));
});

//// PROVEEDORES
Breadcrumbs::for('proveedor', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Proveedores', route('proveedor.index'));
});

Breadcrumbs::for('proveedor.create', function ($trail) {
    $trail->parent('proveedor');
    $trail->push('Crear', route('proveedor.create'));
});

Breadcrumbs::for('proveedor.edit', function ($trail, $proveedor) {
    $trail->parent('proveedor');
    $trail->push($proveedor->id);
    $trail->push('Editar', route('proveedor.edit', $proveedor->id));
});

Breadcrumbs::for('proveedor.movproveedor', function ($trail, $proveedor) {
    $trail->parent('proveedor');
    $trail->push($proveedor->id);
    $trail->push('Movimientos', route('movproveedor.index', $proveedor->id));
});

Breadcrumbs::for('proveedor.deuda', function ($trail, $proveedor) {
    $trail->parent('contacto');
    $trail->push($proveedor->nombreempresa);
    $trail->push('Deuda actual', route('movproveedor.index', $proveedor->id));
});

//// PAGOS
Breadcrumbs::for('pago', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Pago', route('pago.index'));
});

Breadcrumbs::for('pago.create', function ($trail) {
    $trail->parent('pago');
    $trail->push('Crear', route('pago.create'));
});

Breadcrumbs::for('pago.detalle', function ($trail, $pago) {
    $trail->parent('pago');
    $trail->push($pago->id);
    $trail->push('Detalle pago', route('detallepago.index', $pago->id));
});

Breadcrumbs::for('pago.proveedor', function ($trail, $proveedor) {
    $trail->parent('proveedor');
    $trail->push($proveedor->id);
    $trail->push('Pagos', route('pago.pagoProveedor', $proveedor->id));
});