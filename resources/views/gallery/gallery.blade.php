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
            @isset($gallery)
                <div class="main-gallery">
                    {{ $gallery->links() }}
                    <div class="main-gallery-items">
                        @foreach($gallery as $item)
                            <div class="card gallery-card" id="gallery-card-{{ $item->id }}">
                                <img class="card-img" src="{{ $item->image }}" alt="{{ $item->title }}">
                                <div class="">
                                    <div class="card-img-overlay">
                                        <p class="card-text">{{ $item->title }}</p>
                                        <i class="fas  fa-search-plus icon fa-6x"></i>
                                        <p class="card-text-deleted" >Restore</p>
                                        <i class="fas fa-trash-restore icon-deleted fa-6x"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $gallery->links() }}
                </div>
            @endisset
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
