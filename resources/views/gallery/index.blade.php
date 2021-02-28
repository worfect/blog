@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    <div class="content-gallery">
        <div class="header">
            @include('gallery.menu')
        </div>
        <section>
            @if(isset($warning))
                {!! $warning !!}
            @else
            {!! $gallery !!}
            @endif
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
