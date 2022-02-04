<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}{{ isset($PAGE_TITLE) ? " | $PAGE_TITLE" : '' }}</title>

    @livewireStyles
    <link rel=stylesheet href=https://cdn.jsdelivr.net/npm/pretty-print-json@1.1/dist/pretty-print-json.css>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="max-h-screen bg-gray-50">
    {{ $slot }}

    @livewireScripts
    <script defer src=https://cdn.jsdelivr.net/npm/pretty-print-json@1.1/dist/pretty-print-json.min.js></script>
    <script defer src="https://unpkg.com/alpinejs@3.8.1/dist/cdn.min.js"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>
</body>
</html>
