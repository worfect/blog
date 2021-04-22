@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="shell">
        <form class="px-4 py-3" method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="form-group">
                <label> Verify Code </label>
                <input type="text" class="form-control" name="code" placeholder="Verify Code">
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
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection


@section('footer')
    @parent
@endsection

