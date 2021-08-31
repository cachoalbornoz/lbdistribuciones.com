<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/frontend/favicon.ico') }}" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/bootstrap-4.3.1/dist/css/bootstrap.min.css') }}">

    @if (Auth::user())

        <!--Plugin DataTables -->
        <link rel="stylesheet" href="{{ asset('/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/DataTables/FixedHeader-3.1.6/css/fixedHeader.bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/file-input/css/fileinput.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/bower_components/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/bower_components/alert_js/ymz_box.css') }}">
        <link rel="stylesheet" href="{{ asset('/bootstrap-toggle-master/css/bootstrap-toggle.min.css') }}">

    @endif

    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    @yield('stylesheet')

    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
    </script>

</head>

<body style="background-color: #ecf0f5">

    <div class="container-fluid">

        @include('base.header')

        @include('flash::message')

        @yield('breadcrumb')

        @yield('content')

        @include('base.footer')

    </div>


    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap 4.3.1 -->
    <script src="{{ asset('/bootstrap-4.3.1/js/dist/popper.min.js') }}"></script>
    <script src="{{ asset('/bootstrap-4.3.1/js/dist/util.js') }}"></script>
    <script src="{{ asset('/bootstrap-4.3.1/dist/js/bootstrap.min.js') }}"></script>

    @if (Auth::user())

        <!-- DataTable / DataTable Buttons / DataTable Fixed Header / DataTable Moment -->
        <script src="{{ asset('/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('/DataTables/Buttons-1.6.1/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('/DataTables/Buttons-1.6.1/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('/DataTables/JSZip-2.5.0/jszip.js') }}"></script>
        <script src="{{ asset('/DataTables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
        <script src="{{ asset('/DataTables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
        <script src="{{ asset('/DataTables/Buttons-1.6.1/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('/DataTables/Buttons-1.6.1/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('/DataTables/FixedHeader-3.1.6/js/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ asset('/DataTables/moment.min.js') }}"></script>
        <script src="{{ asset('/DataTables/datetime.js') }}"></script>

        <script src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}"> </script>
        <script src="{{ asset('/file-input/js/fileinput.min.js') }}"> </script>
        <script src="{{ asset('/bower_components/toastr/toastr.min.js') }}"> </script>
        <script src="{{ asset('/bower_components/alert_js/ymz_box.min.js') }}"> </script>
        <script src="{{ asset('/bootstrap-toggle-master/js/bootstrap-toggle.min.js') }}"> </script>
        <script src="{{ asset('/js/scripts.js') }}"> </script>

    @endif

    @yield('js')

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
            case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        
            case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
        
            case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
        
            case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
            }
        @endif
    </script>

</body>

</html>
