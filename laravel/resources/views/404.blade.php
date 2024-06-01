<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset("logo.png") }}">
    <title>404</title>
    @vite(['resources/css/main.css', 'resources/js/main.js'])
</head>
<body>
    <div class="content-body">
        <img class="preload" src="{{ asset('logo.png') }}" alt="MedoBear">
        <h3 class="text-center fw-bold text-white title-preload">404 - Помилка</h3>
        <a class="btn btn-warning btn-to-site" href="{{ route("site.catalog") }}">Повернутись на сайт</a>
    </div>
</body>
</html>
