@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="shell">
        <form id="reset-form" class="px-4 py-3" method="POST" action="{{ route('password.reset') }}">
            @csrf
            <div class="form-group">
                <label> Verify Code </label>
                <input type="text" class="form-control @error('code') is-invalid @enderror"  name="code" placeholder="Verify Code">
                @error('code')
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
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
            </div>
            <button type="submit" class="btn btn-primary" name="ResetPasswordSubmitButton">Save</button>
        </form>
    </div>
@endsection


@section('footer')
    @parent
@endsection

