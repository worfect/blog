@foreach($user as $item)
    <form id="change-user-data-form" class="px-4 py-3 " method="post" action="{{ route('profile.update', ['id' => $item->id]) }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="formGroupExampleInput">Name</label>
                <input id="change-user-screen-name-input" type="text" class="form-control @error('screen_name') is-invalid @enderror" name="screen_name" value="{{ $item->screen_name }}">
                @error('screen_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group mb-2">
                <label for="formGroupExampleInput2">Phone</label>
                <input id="change-user-phone-input" type="text" class="form-control @error('phone') is-invalid @enderror" name ="phone" value="{{ $item->phone }}">
                @error('phone')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="formGroupExampleInput2">Email</label>
                <input id="change-user-email-input" type="text" class="form-control @error('email') is-invalid @enderror" name ="email" value="{{ $item->email }}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="ChangeUserDataSubmitButton" data-toggle="modal" data-target="#confPassword">Change User Data</button>
    </form>

    <div class="settings-profile px-4 py-3" id="settings-profile" >
        <a href="{{ route('password.change.form') }}"><button class="btn btn-primary">Change Password</button></a>
        @if(!$item->phoneConfirmed())
            <form>
                <button class="btn btn-primary" disabled>Multi-factor authentication: confirm phone to start</button>
            </form>
        @else
            @if(!$item->isMultiFactor())
                <form class="multi-factor-auth" action="{{ route('profile.multi-factor', ['id' => $item->id, 'action' => 'enable']) }}">
                    <button type="submit" class="btn btn-primary">Multi-factor authentication: disabled</button>
                </form>
            @else
                <form class="multi-factor-auth" action="{{ route('profile.multi-factor', ['id' => $item->id, 'action' => 'disable']) }}">
                    <button type="submit" class="btn btn-primary">Multi-factor authentication: enabled</button>
                </form>
            @endif
        @endif

        <form action="{{ route('profile.verify', ['id' => $item->id, 'source' => 'phone']) }}">
            <button type="submit" class="btn btn-primary" name="PhoneVerifySubmitButton" id="phone-verify-submit-button"
                    @if(!$item->getPhone()) disabled> No phone </button>
            @elseif(!$item->phoneConfirmed()) > Verify phone</button>
            @else  disabled> Phone verified</button> @endif
        </form>

        <form action="{{ route('profile.verify', ['id' => $item->id, 'source' => 'email'] )}}">
            <button type="submit" class="btn btn-primary" name="EmailVerifySubmitButton" id="email-verify-submit-button"
                    @if(!$item->getEmail()) disabled> No email </button>
            @elseif(!$item->emailConfirmed()) > Verify email</button>
            @else  disabled> Email verified</button> @endif
        </form>
        <a href="{{ route('profile.default') }}"><button class="btn btn-primary">Back</button></a>
    </div>
@endforeach
