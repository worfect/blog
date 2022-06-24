<header class="row">
    @include('layouts.logo')

    <button class="btn-header-collapse btn btn-primary d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHeader" aria-expanded="false" aria-controls="collapseHeader" id="collapseHeaderBtn">
        <i class="fa-solid fa-caret-down"></i>
        <i class="fa-solid fa-caret-up"></i>
    </button>
    <div class="collapse d-lg-flex header-collapse row" id="collapseHeader">
        @include('menus.navigation-menu')

        @include('layouts.search')

        @include('menus.user-menu')
    </div>
</header>

