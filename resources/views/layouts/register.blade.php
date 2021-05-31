<form class="px-4 py-3" method="POST" action="{{ route('register') }}" id="register-form">
    @csrf
    <div class="form-group">
        <label>Login</label>
        <input id="login" name="login" type="text" class="form-control @error('login') is-invalid @enderror"  value="{{ old('login') }}" placeholder="Login">
        @error('login')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label> Email / Phone </label>
        <input id="uniqueness" name="uniqueness" type="text" class="form-control @error('uniqueness') is-invalid @enderror
                                                    @error('email') is-invalid @enderror @error('phone') is-invalid @enderror"
                                                                    value="{{ old('uniqueness') }}"  placeholder="Email / Phone">

        @error('uniqueness')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('email')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('phone')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>
    <div class="form-group">
        <label>Password</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label>Confirm password</label>
        <input id="password-conform" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
    </div>
    <button type="submit" name="registerSubmitButton" class="btn btn-primary">Sign up</button>
</form>


