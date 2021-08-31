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

        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

</head>
<body>
    <div class="container-fluid">

        @include('base.header-error')

        @yield('content')

    </div>

</body>
</html>
