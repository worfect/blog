@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="user-profile" id="user-profile">
        <section>
            <article class="col-15">
                <ul class="nav nav-tabs profile-content-tabs">
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link active" href="#user-comment">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link" href="#user-blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link" href="#user-gallery">Gallery</a>
                    </li>

                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link" href="#user-liked">Liked</a>
                    </li>
                </ul>
                @include('profile.content')
            </article>

            <aside class="col-5">
                @include('profile.info')
            </aside>
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
