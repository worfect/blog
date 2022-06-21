@if($NavBar)
    <nav class="navbar dropdown col-auto">
        @foreach($NavBar->roots() as $item)
            <li class="nav-item">
                @if($item->hasChildren())
                    <a class="nav-link" href="{!! $item->url() !!}" role="button" id="dropdownNavMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! $item->title !!}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownNavMenuLink">
                        @foreach($item->children() as $children)
                            <li><a class="nav-link {!! $item->attr('class') !!}" href="{!! $children->url() !!}">{!! $children->title !!}</a></li>
                        @endforeach
                    </ul>
                @else
                    @if($item->url())
                        <a class='nav-link {!! $item->attr('class') !!}' href="{!! $item->url() !!}">{!! $item->title !!} </a>
                    @else
                        <div class='nav-link {!! $item->attr('class') !!}'>{!! $item->title !!}</div>
                    @endif
                @endif
            </li>
        @endforeach
    </nav>
@endif
