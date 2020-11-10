@php
    $config = [
        'appName' => config('app.name'),
        'apiUrl' => 'api',
        'locale' => $locale = app()->getLocale(),
    ];
@endphp
    <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>
    <link href="//cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div id="app"></div>

{{-- Global configuration object --}}
<script>
    window.$config = @json($config);
  </script>

{{-- Load the application scripts --}}
<script src="/js/app.js"></script>
</body>
</html>
