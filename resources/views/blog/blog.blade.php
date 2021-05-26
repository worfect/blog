@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="content-blog">
        <section>
            <article class="col-17">
                <div class="main-blog">
                    {{ $blog->links() }}
                    @foreach($blog as $item)
                        <div class="main-blog-item">
                            <div class="categories">
                                @foreach($item->categories as $category)
                                    <div class="category">
                                        <a href="">{{ $category->getattribute('name') }}</a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="image">
                                <img src="{{ $item->image }}" alt="" />
                                <div class="title">
                                    <div>
                                        <p>
                                            {{ $item->title }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="info">
                                <div class="user">
                                    <a href=""><i class="icon fas fa-user-edit"></i>{{ $item->user->screen_name }}</a>
                                </div>
                                <div class="views">
                                    <i class="fas fa-eye icon"></i><div>{{ $item->views }}</div>
                                </div>
                                <div class="comments">
                                    <a href="{{ route('blog.show', $item->id) }}"><i class="far fa-comment-dots icon"></i>{{ $item->comments->count() }}</a>
                                </div>
                                <div class="date">
                                    <i class="far fa-calendar-minus icon"></i>{{ $item->published_at }}</a>
                                </div>
                            </div>
                            <div class="excerpt">
                                {{ $item->excerpt }}
                            </div>
                            <div class="menu">
                                <button class="btn">
                                    More details
                                </button>
                            </div>
                        </div>
                    @endforeach
                    {{ $blog->links()}}
                </div>
            </article>

            <aside>
                <div class="aside">
                    @include('blog.menu')
                </div>
                <div class="aside">
                    @isset($gallery)
                        @include('blog.gallery')
                    @endisset
                </div>
                <div class="aside">
                    @isset($news)
                        @include('blog.news')
                    @endisset
                </div>
            </aside>
        </section>
    </div>
@endsection


@section('footer')
    @parent
@endsection
