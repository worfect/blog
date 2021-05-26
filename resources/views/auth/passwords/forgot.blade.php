@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="shell">
        <div class="register">
            @include('layouts.forgot')
            <div class="dropdown-divider"></div>
            @include('layouts.social')
        </div>
    </div>


@endsection


@section('footer')
    @parent
@endsection
