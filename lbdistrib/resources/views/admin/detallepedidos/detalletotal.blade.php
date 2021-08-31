<table class="table table-hover table-condensed table-bordered text-center" style="font-size: 1em">
    <tr>
        <th class="w-50">
        </th>
        <th style="width: 10%">
            TOTAL
        </th>
        <th style="width: 10%">
            {{ number_format($cantPedido, 2) }}
        </th>
        <th style="width: 10%">
            {{ number_format($cantEntregado, 2) }}
        </th>
        <th style="width: 10%">
            {{ number_format($cantPedido - $cantEntregado, 2) }}
        </th>
    </tr>
    <tr class=" bg-secondary">
        <td colspan="5">
            &nbsp;
        </td>
    </tr>
    <tr>
        <th class="w-50">

        </th>
        <th style="width: 10%">

        </th>
        <th style="width: 10%">
            MONTO $
        </th>
        <th style="width: 10%">
            {{ number_format($subtotalEntregado, 2) }}
        </th>
        <th style="width: 10%">

        </th>

    </tr>
</table>
