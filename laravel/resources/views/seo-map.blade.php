@extends("layouts.main")

@section("title") Про нас @endsection

@section("head")
    <script src="https://d3js.org/d3.v4.min.js"></script>
    @vite([ 'resources/css/main.css', 'resources/js/main.js', 'resources/css/map.css', 'resources/js/map.js'])
@endsection

@section('seo-block')
    <meta name="description" content="Пасіка MedoBear. Про нас. Пасіка біля заповідника Медобори. На території заповідника існують різні види квітів з яких виходить корисний мед.">
    <meta name="keywords" content="про нас, про пасіку, про товари, про заповідник, медобір, medobear">
    <meta name="author" content="MedoBear">

    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:type" content="Page">
    <meta property="og:title" content="Про нас">
    <meta property="og:description" content="Пасіка MedoBear. Про нас. Пасіка біля заповідника Медобори. На території заповідника існують різні види квітів з яких виходить корисний мед.">
    <meta property="og:image" content="{{ asset('logo.png') }}">
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="row ps-5 pe-5">
                <h2 id="map" data-seo-links="{{$links}}" data-seo-map="{{ $data }}" class="text-center text-muted">Ключові слова сайту</h2>
                <hr>
                <ul style="list-style-type: none;" class="d-flex justify-content-between flex-wrap w-100">
                    @foreach(\Nette\Utils\Json::decode($data) as $key => $word)
                        @if(!isset($word->non_show))
                            <li class="p-2"><a class="link-keywords fw-bold" href="{{ $word->link }}">{{$word->name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="row map-site">
                <h2 class="text-center text-muted">Мапа сайту MedoBear</h2>
                <div class="table-responsive text-center">
                    <svg overflow="auto" class="border" width="1200" height="1200"></svg>
                </div>
            </div>
        </div>
    </div>
@endsection
