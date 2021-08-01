@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="content-profile" id="content-profile">
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
                @include('profile.info')
            </aside>
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
