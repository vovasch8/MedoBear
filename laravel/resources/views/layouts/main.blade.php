<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset("logo.ico") }}">

    <title>@yield("title")</title>

    @yield("head")

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />

    @yield("seo-block")

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @vite([ 'resources/css/main.css', 'resources/js/main.js', 'resources/js/price-filter.js', 'resources/js/slider.js', 'resources/css/price-filter.css', 'resources/css/slider.css', 'resources/css/delivery.css'])
</head>
<body>

    @include("layouts.header")

    <div id="content">
        @yield("content")
    </div>

    @include("layouts.footer")

    <script src="https://cdn.jsdelivr.net/npm/svelte-range-slider-pips/dist/svelte-range-slider-pips.min.js" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
