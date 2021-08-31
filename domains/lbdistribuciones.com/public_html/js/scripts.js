
$(".select2").select2();

$("#image").fileinput({
    language: "es",
    dropZoneEnabled: false,
});

function baseURL(url) {
    return "{{ url(" / ")}}" + url;
}

$(function () {
    var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
    $(".tree li").removeClass("active");
    $('[href$="' + url + '"]')
        .parent()
        .addClass("active");
    $(".treeview").removeClass("menu-open");
    $('[href$="' + url + '"]')
        .closest("li.treeview")
        .addClass("menu-open");
});

function sortTable(tabla) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tabla);
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 0; i < rows.length - 1; i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

function eliminarRegistro(id, ruta) {
    var token = $("input[name=_token]").val();

    ymz.jq_confirm({
        title: "Elimina registro ?",
        text: "<br>",
        no_btn: "No",
        yes_btn: "Si",
        no_fn: function () {
            return false;
        },
        yes_fn: function () {
            $.ajax({
                url: ruta,
                headers: { "X-CSRF-TOKEN": token },
                method: "POST",
                dataType: "json",
                data: { id: id },

                success: function () {
                    $("#fila" + id).remove();
                },
            });
        },
    });
}

$.extend(true, $.fn.dataTable.defaults, {
    language: {
        decimal: ",",
        thousands: ".",
        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        infoPostFix: "",
        infoFiltered: "(filtrado de un total de _MAX_ registros)",
        loadingRecords: "Cargando...",
        lengthMenu: "Mostrar _MENU_ registros",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior",
        },
        processing: "Procesando...",
        search: "Buscar:",
        searchPlaceholder: "Palabra a buscar",
        zeroRecords: "No se encontraron resultados",
        emptyTable: "Ningún dato disponible en esta tabla",
        aria: {
            sortAscending: ": Activar para ordenar la columna de manera ascendente",
            sortDescending: ": Activar para ordenar la columna de manera descendente",
        },
        //only works for built-in buttons, not for custom buttons
        buttons: {
            create: "Nuevo",
            edit: "Cambiar",
            remove: "Borrar",
            copy: "Copiar",
            csv: "fichero CSV",
            excel: "tabla Excel",
            pdf: "documento PDF",
            print: "Imprimir",
            colvis: "Visibilidad columnas",
            collection: "Colección",
            upload: "Seleccione fichero....",
        },
        select: {
            rows: {
                _: "%d filas seleccionadas",
                0: "clic fila para seleccionar",
                1: "una fila seleccionada",
            },
        },
    },
});

function crearDataTable(nombreTabla, columnaOrder, fecha, tipoOrdenamiento = "desc") {

    if (fecha) {

        $("#" + nombreTabla).DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"],
            ],
            paging: true,
            stateSave: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: true,
            responsive: false,
            order: [[columnaOrder, tipoOrdenamiento]],
            columnDefs: [{ targets: fecha, render: $.fn.dataTable.render.moment("DD-MM-YYYY", "DD-MM-YYYY") }],
        });

    } else {

        $("#" + nombreTabla).DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"],
            ],
            paging: true,
            stateSave: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: true,
            responsive: false,
            order: [[columnaOrder, tipoOrdenamiento]],
        });
    }
}
