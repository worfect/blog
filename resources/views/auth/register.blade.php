@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="auth-shell">
        <div class="register">
            @include('layouts.register')
            <div class="dropdown-divider"></div>
            @include('layouts.social')
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
