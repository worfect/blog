<div class="search-menu">
    <form class="search-form row align-items-center" name="search-menu" method="GET" action="{{ route('search') }}">
        <div class="filter-group col-auto row">
            <select class="form-select col" name="method" id="content-method">
                <option @if(request('method') == 'new') selected @endif value="new">New</option>
                <option @if(request('method') == 'old') selected @endif value="old">Old</option>
                <option @if(request('method') == 'best') selected @endif value="best">Best</option>
            </select>
            <select class="form-select col" name="criterion" id="content-criterion" disabled>
                <option @if(request('criterion') == 'views') selected @endif value="views">By Views</option>
                <option @if(request('criterion') == 'rating') selected @endif value="rating">By Rating</option>
                <option @if(request('criterion') == 'comments') selected @endif value="comments">By Comments</option>
            </select>
            <select class="form-select col" name="date" id="content-date" disabled>
                <option @if(request('date') == 'all') selected @endif value="all">All</option>
                <option @if(request('date') == '1') selected @endif value="1">1 Day</option>
                <option @if(request('date') == '3') selected @endif value="3">3 Days</option>
                <option @if(request('date') == '7') selected @endif value="7">7 Days</option>
                <option @if(request('date') == '30') selected @endif value="30">30 Days</option>
                <option @if(request('date') == 'year') selected @endif value="year">Year</option>
            </select>
        </div>
        <div class="filter-group col-auto row">
            <select class="form-select col" name="section" id="search-select-section">
                <option @if(request('section') == 'content') selected @endif value="content">All</option>
                <option @if(request('section') == 'news') selected @endif value="news">News</option>
                <option @if(request('section') == 'blog') selected @endif value="blog">Blog</option>
                <option @if(request('section') == 'gallery') selected @endif value="gallery">Gallery</option>
            </select>
            <input class="search-input form-control" type="text" placeholder="Search" name="search-query" value="{{ request('search-query') }}">
            <button type="submit" class="btn col">Search</button>
        </div>
    </form>
</div>
