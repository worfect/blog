@foreach($comments as $comment)
    <div class="comment">
        <div class="card">
            <div class="card-header">
                <div class="author">
                    {{ $comment->created_at->format('d/m/Y')}}
                    <a href="" class="card-link">{{ $comment->user->screen_name }}</a>
                </div>
                <div class="rating">
                    <i class="fas fa-minus-square"></i>
                    {{ $comment->rating }}
                    <i class="fas fa-plus-square"></i>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $comment->text }}</p>
            </div>
        </div>
    </div>
@endforeach

