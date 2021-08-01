@foreach($user as $item)
    <table class="table table-borderless">
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
            <td>Rating</td>
            <td></td>
        </tr>
        <tr>
            <td>Comments</td>
            <td></td>
        </tr>
        <tr>
            <td>Blog</td>
            <td></td>
        </tr>
        <tr>
            <td>Gallery</td>
            <td></td>
        </tr>
        </tbody>
    </table>
    @if($item->id == Auth::id()) <! –– OR ADMIN ––>
        <a href="{{ route('profile.edit', ['id' => $item->id]) }}"><button class="btn" id="user-menu-btn">Edit</button></a>
    @endif
@endforeach
