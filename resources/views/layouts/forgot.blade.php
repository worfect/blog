
<form id="forgot-password-form" class="px-4 py-3" method="POST" action="{{ route('password.forgot.form') }}">
    @csrf
    <div class="form-group">
        <label>Email / Phone / Login</label>
        <input type="text" class="form-control @error('login') is-invalid @enderror @error('uniqueness') is-invalid @enderror" name="uniqueness"
                                                    value="{{ old('uniqueness') }}"  placeholder="Email / Phone / Login">
        @error('login')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('uniqueness')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    @if(session()->get('switchResetMethod') ?? '')
        <div class="form-group">
            <label>Select method:</label>
            <p>
                <input type="radio" name="dispatchMethod" value="email">{!! session()->get('email') ?? '' !!} <Br>
                <input type="radio" name="dispatchMethod" value="phone">{!! session()->get('phone') ?? '' !!}
            </p>
        </div>
    @endif
    <button type="submit" class="btn btn-primary" name="ForgotPasswordSubmitButton">Reset password</button>
</form>

