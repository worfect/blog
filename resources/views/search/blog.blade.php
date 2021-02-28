<div class="search-blog-result">
    @foreach($items as $item)
        <div class="blog-item">
            <a href="{{ route('blog.show', $item->id ) }}"> <div class="title">
                    <h4>{{ $item->title }}</h4>
                </div>
            </a>
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
