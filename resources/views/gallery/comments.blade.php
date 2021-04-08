@foreach($comments as $item)
    <div class="comment">
        <div class="card">
            <div class="card-header">
                <div class="author">
                    {{ $item->created_at->format('d/m/Y')}}
                    <a href="" class="card-link">{{ $item->user->screen_name }}</a>
                </div>
                <div class="comment-rating-panel">
                    @include('layouts.rating')
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $item->text }}</p>
            </div>
        </div>
    </div>
@endforeach

