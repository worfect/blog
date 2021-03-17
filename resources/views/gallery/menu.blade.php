<div class="search-section">
    <form class ="quick-search-form" method="GET" action="{{ route('search') }}">
        <input class="search-query form-control" type="text" placeholder="Gallery quick search" name="search-query" >
        <input class="section" type="hidden" name="section" value="gallery">
        <div class="search-result">
        </div>
    </form>
</div>


<div class="filter col-9">
    <form class="form-inline" name="content-filter" method="GET" action="{{ route('gallery.index') }}">
        <input type="hidden" name="section" value="content">
        <div class="selector-group">
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
        <button type="submit" class="btn">Apply</button>
    </form>
</div>


<div class="gallery-user-menu col-5">
    @if(Auth::user())
        <div class="user">
            <button type="button" class="btn create-gallery-item" data-toggle="modal">
                Add image
            </button>
            <a href="{{ Route('profile.gallery', ['id' => Auth::id()]) }}">
                <button type="button" class="btn open-profile-gallery">
                    My gallery
                </button>
            </a>
        </div>
    @endif
    @if(!Auth::user())
        <div class="guest">
            <p><a href="{{ route('register') }}">Register</a> or <a href="{{ route('login') }}">login</a> to add an image</p>
        </div>
    @endif
</div>
