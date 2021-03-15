
<div class="modal fade gallery-create gallery-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="edit-gallery-item" id="update-gallery-item" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Edit the title</label>
                        <input class="form-control" id="title" name="title" type="text" value="{{ $post->first()->title }}">
                    </div>

                    <div class="form-group">
                        <label for="text">Edit the description</label>
                        <textarea class="form-control" id="text" name="text" rows="2">{{ $post->first()->text }}</textarea>
                    </div>

                    <input type="hidden" name="id" value="{{ $post->first()->id }}">

                    <div class="down">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            Select categories <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="dropdown-gallery-categories">
                            @foreach($categories as $cat)
                                <li class="dropdown-input"><label><input type="checkbox"
                                 @isset($post->first()->categories)
                                    @foreach($post->first()->categories as $category)
                                        @if($category->id == $cat->id)
                                            checked
                                        @endif()
                                    @endforeach
                                 @endisset()
                                 name="categories[]" value="{{ $cat->id }}">{{ $cat->getattribute('name') }}</label></li>
                            @endforeach
                        </ul>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

