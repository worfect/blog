<div class="news-home">
    <div class="show-news">
        @foreach($news as $item)
            <a href="{{ route('news.show', $item->id) }}">
                <div class="show-news-item">
                    <img src="{{ $item->image }}" alt="" />
                    <div class="title">
                        <div>
                            <p>
                                {{ $item->title }}
                            </p>
                        </div>
                    </div>
                    <div class="excerpt">
                        <div>
                            <p>
                                {{ $item->excerpt }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="nav-news">
        @foreach($news as $item)
            <div class="nav-news-item">
                <img src="{{ $item->image }}" alt="" />
                <div class="title">
                    <div>
                        <p>
                        {{ $item->title }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
