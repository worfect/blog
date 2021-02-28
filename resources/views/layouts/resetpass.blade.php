
<form class="px-4 py-3" method="POST" action="{{ route('password.message') }}">
    @csrf
    <div class="form-group">
        <label>Email / Phone / Login</label>
        <input type="text" class="form-control @error('login') is-invalid @enderror
                            @error('email') is-invalid @enderror @error('phone') is-invalid @enderror @error('uniqueness') is-invalid @enderror" name="uniqueness"
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
                <input type="radio" name="method" value="email">{!! session()->get('email') ?? '' !!} <Br>
                <input type="radio" name="method" value="phone">{!! session()->get('phone') ?? '' !!}
            </p>
        </div>
    @endif
    <button type="submit" class="btn btn-primary">Reset password</button>
</form>

