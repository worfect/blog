<div class="news">
    @foreach($items as $item)
        <div class="news-item">
            <a href="{{ route('blog.show', $item->id ) }}"> <div class="title">
                    <h4>{{ $item->title }}</h4>
                </div>
                <div class="excerpt">
                    {{ $item->excerpt }}
                </div></a>
            <div class="info">
                <div class="views">
                    <i class="fas fa-eye icon"></i><div>999</div>
                </div>
                <div class="comments">
                    <a href="{{ route('blog.show', $item->id) }}"><i class="fas fa-comments icon"></i>{{ $item->comments->count() }}</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
