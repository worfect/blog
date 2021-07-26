@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="content-profile" id="content-profile">
        <div class="header">
            @isset($banner)
                @include('profile.banner')
            @endisset
        </div>

        <section>
            <article class="col-15">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link active" href="#user-blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link" href="#user-gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link" href="#user-comment">Comments</a>
                    </li>
                </ul>

            @include('profile.content')

            </article>

            <aside>
                @isset($blog)
                    @include('profile.info')
                @endisset
            </aside>
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
