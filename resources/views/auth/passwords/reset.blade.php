@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
<div class="shell">
    <div class="reset-pass">
        <form class="px-4 py-3" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label> Password </label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label> Confirm Password </label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password" placeholder="Confirm Password">
            </div>
            <button type="submit" class="btn btn-primary">Set new password</button>
        </form>
    </div>
</div>
@endsection

@section('footer')
    @parent
@endsection
