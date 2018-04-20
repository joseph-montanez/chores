@if (session()->has('flash_notification'))
    @foreach(session()->get('flash_notification') as $notice)
        <div class="alert alert-{{ $notice->level }} text-center" role="alert">
            {!! $notice->message !!}
        </div>
    @endforeach
@endif