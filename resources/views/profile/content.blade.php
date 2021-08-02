<div class="tab-content">
@foreach($user as $item)
    @isset($item->blog)
        <div class="user-blog tab-pane fade show active" id="user-blog">
            @foreach($item->blog as $item)
                <div class="blog-item">
                    <a href="{{ route('blog.show', $item->id ) }}"> <div class="title">
                            <h4>{{ $item->title }}</h4>
                        </div>
                        <div class="excerpt">
                            {{ $item->excerpt }}
                        </div></a>
                    <div class="info">
                        <div class="views">
                            <i class="fas fa-eye icon"></i><div>{{ $item->views }}</div>
                        </div>
                        <div class="comments">
                            <a href="{{ route('blog.show', $item->id) }}"><i class="far fa-comment-dots icon"></i>{{ $item->comments->count() }}</a>
                        </div>
                        <div class="user">
                            <a href=""><i class="icon fas fa-user-edit"></i>{{ $item->user->screen_name }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endisset

    @isset($item->gallery)
        <div class="user-gallery tab-pane fade" id="user-gallery">
            @foreach($item->gallery as $item)
                <div class="blog-item">
                    <a href="{{ route('blog.show', $item->id ) }}"> <div class="title">
                            <h4>{{ $item->title }}</h4>
                        </div>
                        <div class="excerpt">
                            {{ $item->excerpt }}
                        </div></a>
                    <div class="info">
                        <div class="views">
                            <i class="fas fa-eye icon"></i><div>{{ $item->views }}</div>
                        </div>
                        <div class="comments">
                            <a href="{{ route('blog.show', $item->id) }}"><i class="far fa-comment-dots icon"></i>{{ $item->comments->count() }}</a>
                        </div>
                        <div class="user">
                            <a href=""><i class="icon fas fa-user-edit"></i>{{ $item->user->screen_name }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endisset

    @isset($item->comment)
        <div class="user-comment tab-pane fade" id="user-comment">
            @foreach($item->comment as $item)
                <h4>{{ $item->text }}</h4>
            @endforeach
        </div>
    @endisset
@endforeach
</div>

