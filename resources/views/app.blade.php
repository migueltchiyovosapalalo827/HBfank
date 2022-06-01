<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->


        <script type="text/javascript">
            window.Laravel = {
                csrfToken: "{{ csrf_token() }}",
                jsPermissions: {!! auth()->check() ? auth()->user()->jsPermissions() :  "{}" !!}
            }

        </script>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper" id="app">

        </div>
        {{-- ./wrapper --}}


    </body>
</html>
