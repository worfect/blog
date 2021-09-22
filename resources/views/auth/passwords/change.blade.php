@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="shell">
        <form id="change-password-form" class="px-4 py-3 col-6" method="POST" action="{{ route('password.change') }}">
            @csrf

            <div class="form-group">
                <label> Current password </label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                @enderror
            </div>
            <div class="form-group">
                <label> New password </label>
                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
                @error('new_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label> Confirm new password </label>
                <input id="new_password-confirm" type="password" class="form-control" name="new_password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary" name="ChangePasswordSubmitButton">Change</button>
        </form>
    <div>
@endsection


@section('footer')
    @parent
@endsection
