@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="auth-shell">
        <div class="forgot">
            @include('auth.layouts.forgot')
            <div class="dropdown-divider"></div>
            @include('auth.layouts.social')
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
