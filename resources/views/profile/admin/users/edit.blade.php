@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="profile-notice"></div>

    @include('profile.admin.panel')

    <div class="edit-profile" id="edit-profile" >
        @include('profile.admin.users.form')
    </div>
@endsection


@section('footer')
    @parent
@endsection

