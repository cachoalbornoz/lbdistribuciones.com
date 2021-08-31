<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('/bootstrap-4.3.1/dist/css/bootstrap.min.css') }}">


    <style>
        @page {
            margin: 0px 0px;
        }

        body {
            margin-top: 4.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 2cm;
            font-size: 8;
            font-family: sans-serif;
        }

        header {
            line-height: 0.6cm;
            position: fixed;
            top: 0.7cm;
            left: 1.5cm;
            right: 1.5cm;
            height: 4cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0.5cm;
            right: 1.5cm;
            height: 2cm;
        }

        .lb-titulo {
            background-color: #B9D6E5;
            border-radius: 5px;
            text-align: center;
            font-size: 14;
            padding: 10px
        }

        footer .page:after {
            content: counter(page);
        }

        .page-break {
            page-break-after: always;
        }

    </style>


</head>

<body>

    @include('base.header-pdf')

    @yield('content')

    @include('base.footer-pdf')

</body>

</html>
