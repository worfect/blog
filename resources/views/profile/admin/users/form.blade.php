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
        @if($item->status !=  \App\Models\User::STATUS_DELETED)
            @if($item->status == \App\Models\User::STATUS_WAIT)
                <a href="{{ route('admin.user.activate', ['id' => $item->id]) }}"><button class="btn btn-primary">Activate</button></a>
            @elseif($item->status ==  \App\Models\User::STATUS_ACTIVE)
                <a href="{{ route('admin.user.deactivate', ['id' => $item->id]) }}"><button class="btn btn-primary">Deactivate</button></a>
            @endif
            @if($item->status !=  \App\Models\User::STATUS_BANNED)
                <a href="{{ route('admin.user.block', ['id' => $item->id]) }}"><button class="btn btn-primary">Block</button></a>
            @else
                <a href="{{ route('admin.user.unblock', ['id' => $item->id]) }}"><button class="btn btn-primary">Unblock</button></a>
            @endif
            <a href="{{ route('admin.user.delete', ['id' => $item->id]) }}"><button class="btn btn-primary">Delete</button></a>
            <a href="{{ route('profile', ['id' => $item->id]) }}"><button class="btn btn-primary">Profile</button></a>
        @else
            <a href="{{ route('admin.user.restore', ['id' => $item->id]) }}"><button class="btn btn-primary">Restore</button></a>
        @endif
        <a href="{{ url()->previous() }}"><button class="btn btn-primary">Back</button></a>
    </div>
@endforeach
