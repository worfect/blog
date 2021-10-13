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
                <th scope="col">Statuses</th>
                <th scope="col">Phone confirmed</th>
                <th scope="col">Email confirmed</th>
                <th scope="col">Activate</th>
                <th scope="col">Block</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->role }}</td>
                    <td><a href="{{ route('profile' , [ 'id' => $user->id ]) }}">{{ $user->screen_name }}</a></td>
                    <td>{{ $user->getEmail() }}</td>
                    <td>{{ $user->getPhone() }}</td>
                    <td>@foreach ($user->getStatuses() as $status => $expires)
                            {{is_null($expires) ? $status : $status . ' - ' . $expires}}<br>
                        @endforeach</td>
                    <td>{{ $user->phoneConfirmed() ? 'yes' : 'no'}}</td>
                    <td>{{ $user->emailConfirmed() ? 'yes' : 'no' }}</td>
                    <td> @if(!$user->isDeleted())
                            @if($user->isWait())
                                <a href="{{ route('admin.user.activate', ['id' => $user->id]) }}"><button class="btn btn-primary">Activate</button></a>
                            @elseif($user->isActive())
                                <a href="{{ route('admin.user.deactivate', ['id' => $user->id]) }}"><button class="btn btn-primary">Deactivate</button></a>
                            @endif</td>

                            <td>@if(!$user->isBanned())
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

