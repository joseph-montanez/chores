@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">{{ $task->name }}</div>

                    @include('shared.flash')

                    <div class="card-body">
                        <div class="col-sm-10 offset-sm-1">

                            <strong>Description;</strong>
                            <div class="text-muted">
                                {!! nl2br(e($task->description)) !!}
                            </div>

                            @if ($task->reoccurring)
                                <strong>Due At:</strong> {{ @datetime($task->recurr()->current()) }}
                                <p>
                                    <strong>Workers:</strong><br>
                                </p>
                                <div class="row">
                                    <div class="col-sm-6 offset-sm-3">
                                        <ul class="list-group">
                                            @foreach($workers as $worker)
                                                <li class="list-group-item">{{$worker->worker->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <p><strong>Due At:</strong> {{ @datetime($task->started_at) }}</p>
                                <p>
                                    <strong>Worker:</strong><br> {{ $workers->first()->name }}
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
