
@foreach($user as $item)
    <table class="table table-borderless user-info-table">
        <tbody>
        <tr>
            <td>Name</td>
            <td>{{ $item->screen_name }}</td>
        </tr>
        <tr>
            <td>Role</td>
            <td>{{ $item->role }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $item->status }}</td>
        </tr>
        <tr>
            <td>Rating</td>
            <td>{{ $item->comments->sum('rating') + $item->blog->sum('rating') + $item->gallery->sum('rating') }}</td>
        </tr>
        <tr>
            <td>Comments</td>
            <td>{{ count($item->comments) }}</td>
        </tr>
        <tr>
            <td>Blog</td>
            <td>{{ count($item->blog) }}</td>
        </tr>
        <tr>
            <td>Gallery</td>
            <td>{{ count($item->gallery) }}</td>
        </tr>
        </tbody>
    </table>
    @if($item->id == Auth::id())
        <a href="{{ route('profile.edit', ['id' => $item->id]) }}"><button class="btn btn-primary" id="user-edit-menu-btn" name="Edit">Edit</button></a>
    @elseif((Auth::check() and Auth::user()->isAdministrator()))
        <a href="{{ route('admin.user.edit', ['id' => $item->id]) }}"><button class="btn btn-primary" id="user-edit-menu-btn" name="Edit">Edit</button></a>
    @endif
@endforeach

