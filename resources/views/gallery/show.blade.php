@foreach($gallery as $item)
<div class="modal fade gallery-show gallery-modal" id="gallery-modal-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="categories">
                    @foreach($item->categories as $category)
                        <a href="">{{ $category->getattribute('name') }}</a>
                    @endforeach
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="image col-17">
                    <img class="card-img" src="{{ $item->image }}" alt="{{ $item->title }}">
                </div>
                <div class="data col-7">
                    <div class="info" >
                        <div class="card">
                            <div class="card-header">
                                <div class="author">
                                    {{ $item->created_at->format('d/m/Y')}}
                                    <a href="" class="card-link">{{ $item->user->screen_name }}</a>
                                </div>
                                @can('update',  App\Models\Gallery::find($item->id))
                                    <button class="btn gallery-edit-btn" id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                                @endcan
                                @can('delete', App\Models\Gallery::find($item->id))
                                        <button id="{{ $item->id }}" class="btn gallery-delete-btn"><i class="fas fa-trash-alt"></i></button>
                                @endcan

                                <div class="rating">
                                    <i class="fas fa-minus-square"></i>
                                    {{ $item->rating }}
                                    <i class="fas fa-plus-square"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <p class="card-text">{{ $item->text }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="show-comments">
                        @foreach($item->comments as $comment)
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
                    </div>
                    <div class="add-comment">
                        <form class="add-comment-form">
                            <input name="id" type="hidden" value="{{ $item->id }}">
                            <textarea class="form-control" name="text"></textarea>
                            <button type="submit" class="btn btn-primary send-comment-gallery">Add comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
