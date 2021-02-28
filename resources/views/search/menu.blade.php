<div class="search-menu col-15">
    <form class="search-form form-inline" name="search-menu" method="GET" action="{{ route('search') }}">
        <div class="filter-group">
            <select class="custom-select" name="method" id="content-method">
                <option @if(request('method') == 'new') selected @endif value="new">New</option>
                <option @if(request('method') == 'old') selected @endif value="old">Old</option>
                <option @if(request('method') == 'best') selected @endif value="best">Best</option>
            </select>
            <select class="custom-select" name="criterion" id="content-criterion" disabled>
                <option @if(request('criterion') == 'views') selected @endif value="views">By Views</option>
                <option @if(request('criterion') == 'rating') selected @endif value="rating">By Rating</option>
                <option @if(request('criterion') == 'comments') selected @endif value="comments">By Comments</option>
            </select>
            <select class="custom-select" name="date" id="content-date" disabled>
                <option @if(request('date') == 'all') selected @endif value="all">All</option>
                <option @if(request('date') == '1') selected @endif value="1">1 Day</option>
                <option @if(request('date') == '3') selected @endif value="3">3 Days</option>
                <option @if(request('date') == '7') selected @endif value="7">7 Days</option>
                <option @if(request('date') == '30') selected @endif value="30">30 Days</option>
                <option @if(request('date') == 'year') selected @endif value="year">Year</option>
            </select>
        </div>
        <select class="search-select-section custom-select search-section" name="section" id="search-select-section">
            <option @if(request('section') == 'content') selected @endif value="content">All</option>
            <option @if(request('section') == 'news') selected @endif value="news">News</option>
            <option @if(request('section') == 'blog') selected @endif value="blog">Blog</option>
            <option @if(request('section') == 'gallery') selected @endif value="gallery">Gallery</option>
        </select>
        <div class="ui-widget">
            <input class="search-input form-control search-query" type="text" placeholder="Search" name="search-query" value="{{ request('search-query') }}">
        </div>
        <button type="submit" class="btn">Search</button>
    </form>
</div>
