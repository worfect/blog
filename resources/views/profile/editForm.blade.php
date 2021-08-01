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
            <button class="btn btn-primary" name="PhoneVerifySubmitButton"
                    @if($item->phone_confirmed) disabled @endif>{{ $item->phone_confirmed ? 'Verified' : 'Verify'}}</button>
        </div>
        <div class="form-row">
            <div class="form-group col-18">
                <label for="formGroupExampleInput2">Email</label>
                <input id="change-user-email-input" type="text" class="form-control" name ="email" value="{{ $item->email }}">
            </div>
            <button class="btn btn-primary" name="EmailVerifySubmitButton"
                    @if($item->email_confirmed) disabled @endif>{{ $item->email_confirmed ? 'Verified' : 'Verify'}}</button>
        </div>
        <button type="submit" class="btn btn-primary" name="ChangeUserDataSubmitButton">Change User Data</button>
    </form>
@endforeach
