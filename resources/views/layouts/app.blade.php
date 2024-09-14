<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Whitecards</title>

        <script src="https://telegram.org/js/telegram-web-app.js"></script>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @yield('content')

        @stack('scripts')
    </body>
</html>
