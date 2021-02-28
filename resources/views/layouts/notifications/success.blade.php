@extends('layouts.app')

@section('header')
    @parent
@endsection

@section('content')
    <div class="notification">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Notification') }}</div>
                    <div class="success card-body">
                        {{ $message }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
