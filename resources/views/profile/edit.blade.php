@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="edit-profile" id="edit-profile" >
        @include('profile.editForm')
    </div>
    <div class="settings-profile" id="settings-profile" >
        <a href=""><button class="btn btn-primary">2 auth</button></a>
        <a href="{{ route('password.change.form') }}"><button class="btn btn-primary">Change Password</button></a>
    </div>


@endsection


@section('footer')
    @parent
@endsection

