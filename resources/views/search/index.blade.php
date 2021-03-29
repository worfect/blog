@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    <div class="content-search">
        <div class="header">
            @include('search.menu')
        </div>

        <section>
            <div class="search-result-page col-24">
                @include('notice::show')
                @isset($blog)
                    @include('search.blog')
                @endisset
                @isset($gallery)
                    @include('search.gallery')
                @endisset
                @isset($news)
                    @include('search.news')
                @endisset
            </div>
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
