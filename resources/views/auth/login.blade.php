@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="shell">
        <div class="login">
            @include('layouts.login')
            <div class="dropdown-divider"></div>
            @include('layouts.social')
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection

