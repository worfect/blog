@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    <div class="content-blog">
        <section>
            <article class="col-17">
                {!! $blog !!}
            </article>

            <aside>
                <div class="aside">
                    @include('blog.menu')
                </div>
                <div class="aside">
                    {!! $gallery !!}
                </div>
                <div class="aside">
                    {!! $news !!}
                </div>
            </aside>
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
