@foreach ($messages as $message)
    @include('notice::message', ['message' => $message])
@endforeach
