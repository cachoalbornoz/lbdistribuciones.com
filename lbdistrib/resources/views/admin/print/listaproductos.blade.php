<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        @if (isset($marca))
            {{ $marca }}
        @endif
        @if (isset($rubro))
            {{ $rubro }}
        @endif
    </title>

    <style>
        @page {
            margin: 0px 0px;
        }

        body {
            margin-top: 5.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            font-size: 10;
            font-family: sans-serif;
        }

        header {
            position: fixed;
            top: 0.7cm;
            left: 2cm;
            right: 2cm;
            height: 4cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 2cm;
            right: 2cm;
            height: 2cm;
        }

        .lb-titulo {
            background-color: #B9D6E5;
            border-radius: 5px;
            text-align: center;
            font-size: 10;
            padding: 10px
        }

        .border {
            border: 1px solid #000;
        }

        footer .page:after {
            content: counter(page);
        }

        tr.border_bottom td {
            border-bottom: 1pt solid gray;
        }

    </style>


</head>

<body>
    <header>
        <div class="lb-titulo">
            LB REPRESENTACIONES
        </div>
        <table style="width:100%;">
            <tr>
                <td>Juan Carlos Butus - 0343 5046691</td>
                <td>Cuit: 20-22514652-8 Ing.Brutos: 20-22514652-8</td>
            </tr>
            <tr>
                <td>jbutus@hotmail.com</td>
                <td>Inicio de actividades: 09/10/2006</td>
            </tr>
            <tr>
                <td>Luis Leonardo Butus - 0343 4281177 </td>
                <td>RESPONSABLE MONOTRIBUTO</td>
            </tr>
            <tr>
                <td>lbrepresentaciones@hotmail.com</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:75%;">Nombre producto</th>
                <th class=" text-center" style="width:15%;">Marca</th>
                <th style="width:10%;">Imagen</th>
                <th style="width:5%;">Precio</th>
            </tr>
        </table>
    </header>

    <table style="width:100%; font-size: 11px ">
        @foreach ($productos as $producto)
            <tr class="border_bottom">
                <td style="width:5%;">
                    {{ $loop->iteration }}
                </td>
                <td style="width:75%;">
                    {{ substr($producto->nombre, 0, 90) }}
                </td>
                <td class=" text-center" style="width:15%;">
                    @isset($producto->nombremarca)
                        {{ $producto->nombremarca }}
                    @endisset
                </td>
                <td style="width:10%;">
                    @if (isset($producto->image) and is_file('images/upload/productos/' . $producto->image))
                        <?php $cadena = explode('.', $producto->image); ?>
                        @if ($cadena[1] != 'webp')
                            <img src="{{ asset('images/upload/productos/' . $producto->image) }}" alt="--"
                                height="35px" width="35px">
                        @endif
                    @else
                        <img src="{{ asset('images/frontend/imagen-no-disponible.png') }}" height="35px" width="35px">
                    @endif
                </td>
                <td style="width:5%;">
                    {{ $producto->precioventa }}
                </td>
            </tr>
        @endforeach
    </table>

    <footer>
        <table style="width:100%;">
            <tr>
                <td>
                    LB Representaciones
                </td>
                <td>
                    Impresión {{ date('d/m/Y H:i:s', time()) }}
                </td>
                <td>
                    Página <span class="page"></span>
                </td>
            </tr>
        </table>
    </footer>

</body>

</html>
