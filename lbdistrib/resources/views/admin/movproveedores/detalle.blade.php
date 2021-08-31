<table class="table table-bordered table-hover small text-center" id="movproveedores">
    <thead>
        <tr class="bg-secondary text-white">
            <th style="width: 5%">#</th>
            <th style="width: 15%">Fecha</th>
            <th style="width: 15%">Concepto</th>
            <th style="width: 15%">Nro</th>
            <th style="width: 15%">Debe</th>
            <th style="width: 15%">Haber</th>
            <th style="width: 15%">Saldo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movproveedores as $movproveedor)
            <tr id="fila{{ $movproveedor->id }}">
                <td>{{ $movproveedor->id }}</td>
                <td>{{ date('d-m-Y', strtotime($movproveedor->fecha)) }}</td>
                <td>{{ $movproveedor->concepto }}</td>
                <td>{{ $movproveedor->nro }}</td>
                <td>{{ number_format($movproveedor->debe, 2, ',', '.') }}</td>
                <td>{{ number_format($movproveedor->haber, 2, ',', '.') }}</td>
                <td>{{ number_format($movproveedor->saldo, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
