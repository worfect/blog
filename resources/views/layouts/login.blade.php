<form class="px-4 py-3" method="POST" action="{{ route('login') }}" id="login-form">
    @csrf
    <div class="form-group">
        <label> Email / Phone / Login </label>
        <input type="text" class="form-control @error('login') is-invalid @enderror
                            @error('email') is-invalid @enderror @error('phone') is-invalid @enderror" name="uniqueness"
                                                                         value="{{ old('uniqueness') }}"  placeholder="Email / Phone / Login">

        @error('login')
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
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="remember"  {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label">
            Remember me
        </label>
    </div>
    <button type="submit" name="loginSubmitButton" class="btn btn-primary">Sign in</button>
</form>
