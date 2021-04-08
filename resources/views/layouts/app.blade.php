<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Best Blog') }}</title>




    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


</head>
<body>
<div class="container">

    @section('header')
        @include('layouts.header')
    @show


    @section('content')

    @show

    @section('footer')
        @include('layouts.footer')
    @show

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('plugins/slickslider/slick.min.js') }}" defer></script>
<script src="{{ asset('plugins/summernote/summernote.min.js') }}" defer></script>

</body>
</html>
