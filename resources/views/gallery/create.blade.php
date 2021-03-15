<div class="modal fade gallery-create gallery-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="edit-gallery-item" id="store-gallery-item" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Enter the title</label>
                        <input class="form-control" id="title" name="title" type="text" >
                    </div>

                    <div class="form-group">
                        <label for="text">Enter a description</label>
                        <textarea class="form-control" id="text" name="text" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <input class="form-file-input" name="image"  id="image" type="file">
                    </div>

                    <div class="down">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            Select categories <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="dropdown-gallery-categories">
                            @foreach($categories as $item)
                                <li class="dropdown-input"><label><input type="checkbox" name="categories[]"
                                                                         value="{{ $item->getattribute('id') }}">
                                                                        {{ $item->getattribute('name') }}</label></li>
                            @endforeach
                        </ul>

                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
