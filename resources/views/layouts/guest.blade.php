<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url-current" content="{{ url()->current() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome-free/css/all.min.css") }}">

    <link rel="stylesheet" href="{{ asset("assets/dist/css/adminlte.min.css") }}">
</head>

<body class="hold-transition login-page" style="margin-top: -10vh;">
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1"><b>{{ config('app.name') }}</b></a>
            </div>
            <div class="card-body login-card-body">
                {{ $slot }}
            </div>
        </div>

    </div>

    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

    <script src="{{ asset("assets/dist/js/adminlte.min.js") }}"></script>
</body>

</html>