<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light ">

    <a class="navbar-brand" href="#">
        @if (!Auth::guest())
            <span class="text-info">LB</span>
        @else
            <span class="text-info">LB Representaciones</span>
        @endif
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">


        @if (!Auth::guest())
            <ul class="navbar-nav mr-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Movimientos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @can('pedido.index')
                            <a class="dropdown-item" href="{{ route('pedido.index') }}">
                                <i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i>
                                Pedidos
                                @can('pedido.destroy')
                                    <span class="badge text-info">{{ $nro_pedidos }}</span>
                                @endcan
                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('presupuesto.index') }}">
                                <i class="fa fa-calculator text-info" aria-hidden="true"></i>
                                Presupuestos
                                @can('contacto.destroy')
                                    <span class="badge text-info">{{ $nro_presupuestos }}</span>
                                @endcan
                            </a>

                        @endcan

                        @can('pendiente.index')

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('pendiente.index') }}">
                                <i class="fa fa-clock-o text-info" aria-hidden="true"></i>
                                Pendientes
                            </a>
                        @endcan
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Clientes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @can('contacto.index')
                            <a class="dropdown-item" href="{{ route('contacto.index') }}">
                                <i class="fa fa-group text-info" aria-hidden="true"></i>
                                Clientes
                                @can('contacto.destroy')
                                    <span class="badge text-info">{{ $nro_contactos }}</span>
                                    </span>
                                @endcan
                            </a>
                        @endcan

                        @can('venta.index')

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('venta.index') }}">
                                <i class="fa fa-shopping-cart text-info" aria-hidden="true"></i>
                                <span>Ventas</span>
                            </a>

                            <div class="dropdown-divider"></div>

                        @endcan

                        @can('cobro.index')
                            <a class="dropdown-item" href="{{ route('cobro.index') }}">
                                <i class="fa fa-money text-info" aria-hidden="true"></i>
                                <span>Cobros</span>
                            </a>
                        @endcan

                    </div>
                </li>

                @can('cheque.index')

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Proveedores
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ route('proveedor.index') }}">
                                <i class="fa fa-group text-info" aria-hidden="true"></i>
                                Proveedores
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('presupuestop.index') }}">
                                <i class="fa fa-circle-o text-info"></i> Pedidos presupuesto
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('compra.index') }}">
                                <i class="fa fa-circle-o text-info"></i> Compras
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('pago.index') }}">
                                <i class="fa fa-circle-o text-info"></i> Pagos
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('ordenpago.index') }}">
                                <i class="fa fa-handshake-o" aria-hidden="true"></i> Ordenes Pago
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cheques
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('cheque.index') }}">
                                <i class="fa fa-university text-info" aria-hidden="true"></i> Listado
                            </a>
                        </div>
                    </li>
                @endcan

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Productos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        @can('producto.index')
                            <a class="dropdown-item" href="{{ route('producto.index') }}">
                                <i class="fa fa-barcode text-info" aria-hidden="true"></i>
                                Lista de productos
                                <span class="pull-right-container">
                                    <span class="badge text-info">{{ $nro_productos }}</span>
                                </span>
                            </a>

                        @endcan

                        @can('actualizacion.index')

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('actualizacion.parametro') }}">
                                <i class="fa fa-line-chart text-info" aria-hidden="true"></i>
                                Actualizaciones
                            </a>
                            <div class="dropdown-divider"></div>

                        @endcan

                        @can('marca.index')
                            <a class="dropdown-item" href="{{ route('marca.index') }}">
                                <i class="fa fa-registered text-info" aria-hidden="true"></i>
                                Marcas
                            </a>

                            <div class="dropdown-divider"></div>

                        @endcan

                        @can('rubro.index')
                            <a class="dropdown-item" href="{{ route('rubro.index') }}">
                                <span class="fa fa-cubes text-info"></span>
                                Rubros
                            </a>
                        @endcan
                    </div>
                </li>

                @can('users.index')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administracion
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.index') }}">
                                <i class="fa fa-lock text-info" aria-hidden="true"></i>
                                Usuarios
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('roles.index') }}">
                                <i class="fa fa-address-card text-info" aria-hidden="true"></i>
                                Roles
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('vendedor.index') }}">
                                <i class="fa fa-address-card text-info" aria-hidden="true"></i>
                                Vendedores
                            </a>

                        </div>
                    </li>
                @endcan

            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">

                        <small>
                            {{ Auth::user()->name }} ({{ Auth::user()->tieneRol() }} <i
                                class="fa fa-circle text-info"></i> )
                        </small>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item text-center" href="#">
                                @if (isset(Auth::user()->image))
                                    <img src="{{ asset('/images/upload/usuarios/' . Auth::user()->image) }}"
                                        class=" img-rounded d-inline-block align-top" width="40" height="40"
                                        alt="Usuario">
                                @else
                                    <img src="{{ asset('/images/frontend/user.jpg') }}"
                                        class=" img-rounded d-inline-block align-top" width="40" height="40"
                                        alt="Usuario">
                                @endif
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('users.editprofile', Auth::user()->id) }}">
                                <i class="fa fa-edit text-info" aria-hidden="true"></i> Editar perfil
                            </a>
                        </li>

                        @can('roles.index')
                            <li class="dropdown-divider"></li>
                            <li>
                                <a href="{{ route('limpiar') }}" class="dropdown-item">
                                    <i class="fa fa-trash text-info" aria-hidden="true"></i> Limpiar sistema
                                </a>
                            </li>
                        @endcan
                        <li class="dropdown-divider">
                        <li>
                            <a href="{{ route('password.form') }}" class="dropdown-item" class="btn btn-default">
                                <i class="fa fa-key text-info" aria-hidden="true"></i> Cambiar clave
                            </a>
                        </li>
                        <li class="dropdown-divider">
                        <li>
                            <a class="dropdown-item" href="{{ url('/logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                title="Salir">
                                <i class="fa fa-sign-out text-info"> </i> Salir del sistema
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        @else
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fa fa-lock text-info" aria-hidden="true"></i> Ingreso
                    </a>
                </li>
            </ul>
        @endif


    </div>
</nav>
