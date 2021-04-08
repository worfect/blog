@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    <div class="menu-gallery">
        @include('gallery.menu')
    </div>
    <div class="content-gallery">
        @include('gallery.content')
    </div>
@endsection


@section('footer')
    @parent
@endsection
