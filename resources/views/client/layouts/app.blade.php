<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', 'Dashboard') - {{ __('Client Dashboard') }} </title>
    <link rel="icon" href="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- Bootstrap 5 --}}
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-5.3.2/css/bootstrap.min.css') }}">

    @stack('css_link')
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('css')
</head>

<body class="hold-transition sidebar-mini">


    <div class="wrapper">
        @if (auth()->guard('client')->check())
            @include('client.includes.nav')
            @include('client.includes.sidebar')
            <div class="content-wrapper">
        @endif
        @yield('content')
        @if (auth()->guard('client')->check())
    </div>
    @include('client.includes.footer')
    @endif
    </div>


    {{-- Jquery  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Bootstrap --}}
    <script src="{{ asset('plugins/bootstrap-5.3.2/js/bootstrap.bundle.min.js') }}"></script>

    @stack('js_link')

    <script>
        $(document).ready(function() {
            // Initialize ClipboardJS
            var clipboard = new ClipboardJS('.copy-btn');

            clipboard.on('success', function(e) {
                toastr.success('Copied to clipboard: ' + e.text); // Toastr success notification
                e.clearSelection(); // Clear the selected text
            });

            clipboard.on('error', function(e) {
                toastr.error('Failed to copy!'); // Toastr error notification
            });
        });
    </script>
    @stack('js')
</body>

</html>
