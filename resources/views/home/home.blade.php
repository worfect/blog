@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    <div class="content-home">
        <div class="header">
            @isset($banner)
                @include('home.banner')
            @endisset
        </div>

        <section>
            <article class="col-15">
                @isset($news)
                    @include('home.news')
                @endisset
            </article>

            <aside>
                @isset($blog)
                    @include('home.blog')
                @endisset
            </aside>
        </section>

        <div class="footer">
            <div class="left-side  col-9">
                @isset($gallery)
                    @include('home.gallery')
                @endisset
            </div>
            <div class="right-side">
                @isset($portfolio)
                    @include('home.portfolio')
                @endisset
            </div>
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
