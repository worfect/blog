<div class="tab-content">
@foreach($user as $item)

    @isset($item->comments)
        <div class="user-comment tab-pane fade show active" id="user-comment">
            @foreach($item->comments->sortByDesc('created_at') as $comment)
                <div class="user-comment-item">
                    <div class="header">
                        <div class="header-item title">
                            <a @if((new $comment->commentable_type)->name == 'gallery') class="gallery-card" id="gallery-card-{{ $comment->commentable_id }}"
                               href="javascript: void(0)">
                               @else()
                               href="{{ route((new $comment->commentable_type)->name . '.show', $comment->commentable_id ) }}">
                                @endif()
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
            <div class="user-blog-items">
                @foreach($item->blog->sortByDesc('created_at') as $blog)
                    <div class="user-blog-item">
                        <div class="header-item title">
                            <a href="{{ route('blog.show', $blog->id ) }}">
                                {{ $blog->title }}
                            </a>
                        </div>
                        <div class="header-item rating">
                            Rating: {{ $blog->rating }}
                        </div>
                        <div class="header-item comments">
                            Comments: {{ $blog->comments->count() }}
                        </div>
                        <div class="header-item views">
                            Views: {{ $blog->views }}
                        </div>
                        <div class="header-item date">
                            Date: {{ $blog->updated_at }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endisset

    @isset($item->gallery)
        <div class="user-gallery tab-pane fade" id="user-gallery">
            <div class="group-gallery">
                <div class="main-gallery-items">
                    @foreach($item->gallery->sortByDesc('created_at') as $gallery)
                        <div id="gallery-card-{{ $gallery->id }}" class="card gallery-card content-item" >
                            <img class="card-img" src="{{ $gallery->image }}" alt="{{ $gallery->title }}">
                            <div class="card-img-overlay">
                                <p class="card-text">{{ $gallery->title }}</p>
                                <i class="fas  fa-search-plus icon fa-6x"></i>
                                <p class="card-text-deleted" >Restore</p>
                                <i class="fas fa-trash-restore icon-deleted fa-6x"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endisset

    @isset($item->attitude)
        <div class="user-liked tab-pane fade" id="user-liked">
            <div class="group-liked">
                @foreach($item->attitude->sortByDesc('created_at') as $attitude)
                <div class="user-liked-item">
                    <div class="header">
                        <div class="header-item title">
                            <a @if((new $attitude->attitudeable_type)->name == 'gallery') class="gallery-card" id="gallery-card-{{ $attitude->attitudeable_id }}"
                               href="javascript: void(0)">
                                {{ $attitude->attitudeable_type::where('id', $attitude->attitudeable_id)->value('title') }}
                                @else()
                                    @if((new $attitude->attitudeable_type)->name == 'comment')
                                        href="">
                                        {{ $attitude->attitudeable_type::where('id', $attitude->attitudeable_id)->value('text') }}
                                    @else()
                                        href="{{ route((new $attitude->attitudeable_type)->name . '.show', $attitude->attitudeable_id ) }}">
                                        {{ $attitude->attitudeable_type::where('id', $attitude->attitudeable_id)->value('title') }}
                                    @endif()
                                @endif()
                            </a>
                        </div>
                        <div class="header-item date">
                            Date: {{ $attitude->updated_at }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endisset
@endforeach
</div>
