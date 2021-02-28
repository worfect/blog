@foreach (session('notice', collect())->toArray() as $message)
    @include('notice::message')
@endforeach
{{ session()->forget('notice') }}
