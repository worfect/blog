<div class="modal fade confirm-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
                <div class="row justify-content-center">
                    <div class="card">
                        <div class="card-header">{{ __('Confirm Password') }}</div>
                        <div class="card-body">
                            {{ __('Please confirm your password before continuing.') }}
                            <form id="confirm-password-form-modal" class="px-4 py-3" method="POST" action="{{ route('password.confirm') }}">
                                @csrf
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror

                                </div>
                                <div>
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
</div>
