@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="profile-notice"></div>
    <div class="edit-profile" id="edit-profile" >
        @include('profile.editForm')
    </div>
@endsection


@section('footer')
    @parent
@endsection

