
@if ($message['overlay'])
    @include('notice::modal', [
        'title'      => $message['title'],
        'body'       => $message['message']
    ])
@else
    <div class="notice-message alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }}"
         role="alert"
    >
        @if ($message['important'])
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-hidden="true"
            >&times;</button>
        @endif

        {!! $message['message'] !!}
    </div>
@endif
