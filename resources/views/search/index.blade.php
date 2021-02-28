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
                {!! $gallery ?? '' !!}
                {!! $blog ?? '' !!}
                {!! $news ?? '' !!}
            </div>
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
