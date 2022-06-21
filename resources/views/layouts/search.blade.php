<form class="input-group col-auto" method="GET" action="{{ route('search') }}">
    <input class="search-query input-group-prepend" type="text" placeholder="Search" name="search-query">
    <input class="section" type="hidden" name="section" value="content">
    <button class="btn btn-success input-group-append" type="submit">Search</button>
</form>
