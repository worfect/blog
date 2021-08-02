@foreach($user as $item)
    <form id="change-user-data-form" class="col-16" method="post" action="{{ route('profile.update', ['id' => $item->id]) }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-18">
                <label for="formGroupExampleInput">Name</label>
                <input id="change-user-screen-name-input" type="text" class="form-control" name="screen_name" value="{{ $item->screen_name }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-18 mb-2">
                <label for="formGroupExampleInput2">Phone</label>
                <input id="change-user-phone-input" type="text" class="form-control" name ="phone" value="{{ $item->phone }}">
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-18">
                <label for="formGroupExampleInput2">Email</label>
                <input id="change-user-email-input" type="text" class="form-control" name ="email" value="{{ $item->email }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="ChangeUserDataSubmitButton">Change User Data</button>
    </form>
    <div class="settings-profile" id="settings-profile" >
        <a href="{{ route('password.change.form') }}"><button class="btn btn-primary">Change Password</button></a>
        @if($item->)
            <form action="{{ route('profile.multi-factor', ['id' => $item->id, 'action' => 'on']) }}">
                <button class="btn btn-primary">Multi-factor authentication: disabled</button>
            </form>
        @else
            <form action="{{ route('profile.multi-factor', ['id' => $item->id, 'action' => 'off']) }}">
                <button class="btn btn-primary">Multi-factor authentication: enabled</button>
            </form>
        @endif
        <form action="{{ route('profile.verify', ['id' => $item->id, 'source' => 'phone']) }}">
            <button type="submit" class="btn btn-primary" name="PhoneVerifySubmitButton" id="phone-verify-submit-button"
                    @if(!$item->phone) disabled> No phone </button>
            @elseif(!$item->phone_confirmed) > Verify phone</button>
            @else  disabled> Phone verified</button> @endif
        </form>

        <form action="{{ route('profile.verify', ['id' => $item->id, 'source' => 'email'] )}}">
            <button type="submit" class="btn btn-primary" name="EmailVerifySubmitButton" id="email-verify-submit-button"
                    @if(!$item->email) disabled> No email </button>
            @elseif(!$item->email_confirmed) > Verify email</button>
            @else  disabled> Email verified</button> @endif
        </form>
    </div>
@endforeach

