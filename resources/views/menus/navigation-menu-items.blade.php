@foreach($items as $item)
    <li class="nav-item ">
        @if($item->url())
            <a class='nav-link {!! $item->attr('class') !!}' href="{!! $item->url() !!}">{!! $item->title !!} </a>
        @else
            <div class='nav-link {!! $item->attr('class') !!}'>{!! $item->title !!}</div>
        @endif

        @if($item->hasChildren())
            <ul class="dropdown-menu dd-menu-nav">
                @include('menus.navigation-menu-items', ['items' => $item->children()])
            </ul>
        @endif
    </li>
@endforeach
