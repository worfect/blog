<form class="input-group col-6" method="GET" action="{{ route('search') }}">
    <input class="section" type="hidden" name="section" value="content">
    <input class="search-query" type="text" placeholder="Search" name="search-query">
    <button class="btn btn-success" type="submit">Search</button>
</form>
