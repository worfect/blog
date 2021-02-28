@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    <div class="content row">
        <section class="article col-sm row">

            <div class=" header col-sm">
                {{ $user->login }}
            </div>


            <div class="post col-sm">
                fghfgjghjgh</div>
            <div class="footer col-sm">
                менюшечки тут всякие
            </div>
        </section>
        <aside class="info col-sm-6">
            пользователя панель наверное, что же кще то
        </aside>

    </div>
@endsection


@section('footer')
    @parent
@endsection
