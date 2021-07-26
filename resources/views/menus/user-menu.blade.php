<div class="user-menu col-sm-2">
    @if(Auth::user())
        <button class="btn" id="user-menu-btn">
            User
        </button>
        <div class="dropdown-menu menu-profile" id="user-menu-dropdown">
            <div class="switch-user-menu">
                <a class="dropdown-item" id="" href="{{ route('profile.default') }}">Profile</a>
                <a class="dropdown-item" id="">Notifications</a>
                <div class="dropdown-divider"></div>
                <form class="logout" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    @endif
    @if(!Auth::user())
        <button class="btn" id="user-menu-btn">
            Sign in
        </button>
        <div class="dropdown-menu menu-auth" id="user-menu-dropdown">
            <div id="forms">
                <div  id='signin'>
                    @include('layouts.login')
                </div>

                <div  id='signup'>
                    @include('layouts.register')
                </div>

                <div id="request-pass">
                    @include('layouts.forgot')
                </div>

            </div>

            <div id="switch-menu-auth">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" id="tosignin">Have an account? Sign in</a>
                <a class="dropdown-item" id="tosignup">Don't have an account? Sign up</a>
                <a class="dropdown-item" id="toreqpass">Forgot password?</a>
                <div class="dropdown-divider"></div>
            </div>
            @include('layouts.social')
        </div>
    @endif
</div>
