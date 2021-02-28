@if($NavBar)
    <nav class="nav navbar col navbar-expand-lg">
        @include('menus.navigation-menu-items', ['items' => $NavBar->roots()])
    </nav>
@endif
