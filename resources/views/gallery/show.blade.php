@foreach($items as $item)
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
                <div class="image col-18">
                    <img class="card-img" src="{{ $item->image }}" alt="{{ $item->title }}">
                </div>
                <div class="data">
                    <div class="info">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $item->title }}</h6>
                                <p class="card-text">
                                    {{ $item->published_at }}
                                    {{ $item->content_html }}
                                </p>
                                <a href="#!" class="card-link">Card link</a>
                                <a href="#!" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                    <div class="comments">
                        <div class="show-comments">
                            @foreach($item->comments as $comment)
                                <div class="comment">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text"> {{ $comment->content_html }} </p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="date">
                                                {{ $comment->created_at }}
                                            </div>
                                            <div class="user">
                                                {{ $comment->user->screen_name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="add-comment">
                            <form>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
