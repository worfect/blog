@if((Auth::check() and Auth::user()->isAdministrator()))
    <div class="admin-menu-btn">
        <a href="{{ route('admin.users') }}"><button class="btn btn-primary" id="admin-users-btn" >Users</button></a>
        <a href="{{ route('admin.comments') }}"><button class="btn btn-primary" id="moder-comments-btn">Comments</button></a>
        <a href="{{ route('admin.settings') }}"><button class="btn btn-primary" id="moder-settings-btn">Settings</button></a>
        <a href="{{ route('admin.services') }}"><button class="btn btn-primary" id="moder-content-btn">Services</button></a>
        <a href="{{ route('admin.content') }}"><button class="btn btn-primary" id="moder-content-btn">Add content</button></a>
    </div>
    <div class="admin-menu-btn">
        <a href="{{ route('services.sms.show') }}"><button class="btn btn-primary" id="moder-content-btn">SMS</button></a>
        <a href=""><button class="btn btn-primary" id="moder-content-btn">Mail</button></a>
    </div>
@endif
