<div class="create">
    @if(Auth::user())
    <div class="user">
        <a href="{{ route('blog.create') }}">
            <button class="btn" id="">
                Create post
            </button>
        </a>
    </div>
    @endif
    @if(!Auth::user())
    <div class="guest">
        <p><a href="{{ route('register') }}">Register</a> or <a href="{{ route('login') }}">login</a> to create post</p>
    </div>
    @endif
</div>

