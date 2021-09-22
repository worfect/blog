@extends('layouts.app')

@section('header')
    @parent
@endsection

@section('content')
    @parent
    <div class="auth-group row justify-content-center">
        <div class="card col-md-8">
            <div class="card-header">Verify your account</div>
            <div class="card-body">
                A confirmation code has been sent to your phone/email.
                Enter it in the input field below
                <form id="verify-form" class="d-inline" method="POST" action="{{ route('verification.verify') }}">
                    @csrf
                    <br>
                    <input type="text" name="code">
                    <button type="submit" class="btn" name="verifySubmitButton">Send</button>
                </form>
                <form id="resend-form" class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <input type="text" name="id" hidden value="{{ session()->get('id') }}">
                    <br>
                    <button type="submit" class="btn" name="resendSubmitButton">Click to send the code again</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
