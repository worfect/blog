@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent

    <div class="auth-group">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Confirm Password') }}</div>
                    <div class="card-body">
                        {{ __('Please confirm your password before continuing.') }}
                        <form id="confirm-password-form" class="px-4 py-3" method="POST" action="{{ route('password.confirm') }}">
                            @csrf
                            <div class="form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror

                            </div>
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary"  name="ConfirmPasswordSubmitButton">
                                    {{ __('Confirm Password') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
