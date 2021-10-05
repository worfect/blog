@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent

    @include('profile.admin.panel')


    <div class="users-table">
        <table class="table table-striped table-bordered" id="admin-users-table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Role</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Status</th>
                <th scope="col">Phone confirmed</th>
                <th scope="col">Email confirmed</th>
                <th scope="col">Activate</th>
                <th scope="col">Block</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)

                <tr @if($user->status ==  \App\Models\User::STATUS_DELETED)class="deleted"@endif>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->role }}</td>
                    <td><a href="{{ route('profile' , [ 'id' => $user->id ]) }}">{{ $user->screen_name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->status }}</td>
                    <td>{{ $user->phone_confirmed }}</td>
                    <td>{{ $user->email_confirmed }}</td>
                    <td> @if($user->status !=  \App\Models\User::STATUS_DELETED)
                            @if($user->status == \App\Models\User::STATUS_WAIT)
                                <a href="{{ route('admin.user.activate', ['id' => $user->id]) }}"><button class="btn btn-primary">Activate</button></a>
                            @elseif($user->status ==  \App\Models\User::STATUS_ACTIVE)
                                <a href="{{ route('admin.user.deactivate', ['id' => $user->id]) }}"><button class="btn btn-primary">Deactivate</button></a>
                            @endif</td>
                            <td>@if($user->status !=  \App\Models\User::STATUS_BANNED)
                                    <a href="{{ route('admin.user.block', ['id' => $user->id]) }}"><button class="btn btn-primary">Block</button></a>
                                @else
                                    <a href="{{ route('admin.user.unblock', ['id' => $user->id]) }}"><button class="btn btn-primary">Unblock</button></a>
                                @endif</td>
                            <td><a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"><button class="btn btn-primary" id="">Edit</button></a></td>
                         @else
                            <td></td>
                            <td><a href="{{ route('admin.user.restore', ['id' => $user->id]) }}"><button class="btn btn-primary">Restore</button></a></td>
                         @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection


@section('footer')
    @parent
@endsection

