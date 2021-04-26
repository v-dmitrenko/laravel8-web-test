<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Config::get('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/front.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container" id="app">
        <h1>Laravel 8 Demo App</h1>
        <router-view></router-view>
    </div>

    @section('scripts')
        <script src="{{ mix('js/front.js') }}"></script>
    @show
</body>
</html>
