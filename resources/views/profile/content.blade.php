<div class="tab-content">
@foreach($user as $item)

    @isset($item->comment)
        <div class="user-comment tab-pane fade show active" id="user-comment">
            @foreach($item->comment->sortByDesc('updated_at') as $comment)
                <div class="user-comment-item">
                    <div class="header">
                        <div class="header-item title">
                            <a href="{{ route((new $comment->commentable_type)->name . '.show', $comment->commentable_id ) }}">
                                {{ $comment->commentable->title }}
                            </a>
                        </div>

                        <div class="header-item rating">
                            Rating: {{ $comment->rating }}
                        </div>
                        <div class="header-item date">
                            Date: {{ $comment->updated_at }}
                        </div>
                    </div>
                    <div class="content">
                        <div class="content-item text">
                            {{ $comment->text }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endisset

    @isset($item->blog)
        <div class="user-blog tab-pane fade" id="user-blog">
            @foreach($item->blog->sortByDesc('updated_at') as $blog)
                <div class="user-blog-item">
                    <div class="user-comment-item">
                        <div class="header">
                            <div class="header-item title">
                                <a href="{{ route('blog.show', $blog->id ) }}">
                                    {{ $blog->title }}
                                </a>
                            </div>
                            <div class="header-item rating">
                                Rating: {{ $blog->rating }}
                            </div>
                            <div class="header-item date">
                                Date: {{ $blog->updated_at }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endisset

    @isset($item->gallery)
        <div class="user-gallery tab-pane fade" id="user-gallery">
            <div class="group-gallery">
                @foreach($item->gallery->sortByDesc('updated_at') as $gallery)
                    <div class="user-gallery-item">
                        <div class="card gallery-card" id="gallery-card-{{ $gallery->id }}">
                            <img class="card-img" src="{{ $gallery->image }}" alt="{{ $gallery->title }}">
                            <div class="">
                                <div class="card-img-overlay">
                                    <p class="card-text">{{ $gallery->title }}</p>
                                    <i class="fas  fa-search-plus icon fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endisset

    @isset($item->attitude)
        <div class="user-liked tab-pane fade" id="user-liked">
            @foreach($item->attitude->sortByDesc('updated_at') as $attitude)
                {{ $attitude->attitudeable_id }} - {{ $attitude->attitudeable_type }}
            @endforeach
        </div>
    @endisset
@endforeach
</div>
