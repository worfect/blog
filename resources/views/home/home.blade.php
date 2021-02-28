@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    <div class="content-home">
        <div class="header">
            {!! $banner !!}
        </div>

        <section>
            <article class="col-15">
                {!! $news !!}
            </article>

            <aside>
                {!! $blog !!}
            </aside>
        </section>

        <div class="footer">
            <div class="left-side  col-9">
                {!! $gallery !!}
            </div>
            <div class="right-side">
                {!! $portfolio !!}
            </div>
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
