@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="gallery">
        <div class="btn-gallery-menu-collapse d-lg-none row" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGalleryMenu" aria-expanded="false" aria-controls="collapseHeader" id="collapseGalleryMenuBtn">
            <button class="gallery-menu-down">
                Gallery menu<i class="fa-solid fa-caret-down"></i>
            </button>
            <button class="gallery-menu-up">
                Gallery menu<i class="fa-solid fa-caret-up "></i>
            </button>
        </div>
        <div class="collapse d-lg-flex gallery-menu-collapse row" id="collapseGalleryMenu">
            <div class="menu-gallery row">
                @include('gallery.menu')
            </div>
        </div>
        <div class="content-gallery">
            @include('gallery.content')
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
