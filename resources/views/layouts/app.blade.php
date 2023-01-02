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
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iziToast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css') }}">

    <link rel="stylesheet" href="{{ asset("assets/dist/css/adminlte.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/dist/css/custom.css") }}">
    @stack('styles')
    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
    <div class="wrapper">
        @include('layouts.navbar')        
        @include('layouts.navigation')        

        <div class="content-wrapper">
            <section class="content-header pt-2 pb-0">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @yield('header')
                    </div>
                    <div id="alert_error" class="callout callout-danger mb-2" style="display: none;">
                        <button type="button" class="close" onclick="$('#alert_error').hide()">×</button>
                        <h5 id="alert_error_title" class="text-danger">Input Error!</h5>
                        <div id="alert_error_msg"></div>
                        <ul id="alert_error_list" class="pl-3 mb-0"></ul>
                    </div>
                </div>
            </section>

            @yield('content')
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="https://github.com/vantanto/vpos_lite">vpos_lite</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/iziToast/js/iziToast.min.js') }}"></script>  
    <script src="{{ asset('assets/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js') }}"></script>  

    <script src="{{ asset("assets/dist/js/adminlte.min.js") }}"></script>    
    <script src="{{ asset("assets/dist/js/sidebar-collapse.js") }}"></script>    
    <script src="{{ asset('assets/dist/js/custom.js') }}"></script>
    <script src="{{ asset('assets/dist/js/submitForm.js') }}"></script>

    <script type="text/javascript">
        // Success Message
        @if(session('success'))
        iziToast.success({
            title: 'Success',
            message: "<?php echo session('success'); ?>",
        });
        @endif
        // Errors Message
        @if(session('error'))
        iziToast.error({
            title: 'Error',
            message: "<?php echo session('error'); ?>",
        });
        @endif
    </script>
    <script>
        $.fn.select2.defaults.set("theme", "bootstrap4");
        $(document).on('select2:open', function(e) {
            setTimeout(() => document.querySelector('input.select2-search__field').focus(), 0);
        });
    </script>

    @method('scripts')
    @yield('script')
</body>

</html>