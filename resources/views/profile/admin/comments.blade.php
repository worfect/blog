@extends('layouts.app')


@section('header')
    @parent
@endsection

@section('content')
    @parent

    @include('profile.admin.panel')

    <div class="comments-table"></div>
    <table class="table table-striped table-bordered" id="admin-comments-table">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">User</th>
            <th scope="col">Post</th>
            <th scope="col">Text</th>
            <th scope="col">Rating</th>
            <th scope="col">Delete</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->updated_at }}</td>
                <td><a href="{{ route('profile' , [ 'id' => $comment->user->id ]) }}">{{ $comment->user->screen_name }}</a></td>
                <td><a @if((new $comment->commentable_type)->name == 'gallery') class="gallery-card" id="gallery-card-{{ $comment->commentable_id }}"
                                           href="javascript: void(0)">
                        @else()
                            href="{{ route((new $comment->commentable_type)->name . '.show', $comment->commentable_id ) }}">
                        @endif()
                        {{ $comment->commentable->title }}
                    </a></td>
                <td>{{ $comment->text }}</td>
                <td>{{ $comment->rating }}</td>
                @if(is_null($comment->deleted_at))
                    <td><button class="btn btn-primary" id="">Delete</button></td>
                @else
                    <td><button class="btn btn-primary" id="">Restore</button></td>
                @endif
                <td><button class="btn btn-primary" id="" >Edit</button></td>
            </tr>
        @endforeach
    </table>
    </div>
@endsection


@section('footer')
    @parent
@endsection

