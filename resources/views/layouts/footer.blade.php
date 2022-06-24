<footer class="fixed-bottom">
    <div class="container-footer row">
        <div class="copyright">
            <h6>© 2022 Copyright: <a href="https://www.blog-test.com/"> BestBlog </a></h6>
        </div>
        <div class="duplicate-navigate flex col-auto">
            @if(!Auth::user())
                <a class="footer-item" title="Signin" href="{{ route('login') }}"><i class="fas fa-sign-in-alt fa-2x"></i></a>
                <a class="footer-item" title="Signup" href="{{ route('register') }}"><i class="fas fa-user-plus fa-2x"></i></a>
                <a class="footer-item" title="Reset password" href="{{ route('password.forgot.form') }}"><i class="fas fa-unlock-alt fa-2x"></i></a>
            @endif

            @if(Auth::user())
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button  name="logoutSubmitButton" type="submit" class="btn footer-item" title="Logout"><i class="fas fa-sign-out-alt fa-2x"></i></button>
                </form>
                <a class="footer-item" title="User profile" href="{{ route('profile', Auth::user()->id) }}"><i class="far fa-id-card fa-2x"></i></a>
            @endif
        </div>
    </div>
</footer>

