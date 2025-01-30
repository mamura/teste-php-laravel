<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ltr horizontalmenu">
    <noscript>Você precisa habilitar Javascript para rodar esta aplicação.</noscript>
    
    <div id="app" class="page">
        <x-header />
        <div class="main-content side-content">
            @yield('content')
        </div>
        <x-footer />
    </div>
</body>
</html>
