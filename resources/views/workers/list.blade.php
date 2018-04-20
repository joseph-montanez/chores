@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                    <div class="card-header">All Workers</div>

                    @include('shared.flash')

                    <div class="card-body">
                        @if ($workers->count() === 0)
                            <p class="text-center text-info">You have no workers, why not add one?</p>
                            <p class="text-center">
                                <a href="/workers/add" class="btn btn-primary">
                                    Add Worker
                                </a>
                            </p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($workers as $worker)
                                    <li class="list-group-item">
                                        {{ Html::linkRoute('worker.edit.index', $worker->name, ['id' => $worker->id]) }}



                                        <a class="btn btn-xs btn-link text-danger float-right" style="margin-left: 10px"
                                           onclick="return confirm('Are you sure you want to delete this worker?')"
                                           href="{{ route('worker.delete', ['id' => $worker->id]) }}">
                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                        </a>

                                        <a class="btn btn-xs btn-link float-right" href="{{ route('worker.edit.index', ['id' => $worker->id]) }}">
                                            <span class="fas fa-edit" aria-hidden="true"></span>
                                            Edit Worker
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="card-footer text-center">
                        <a class="btn btn-primary" href="{{ route('worker.add.index') }}">Add Worker</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{@full_asset('/js/workers.js')}}"></script>
@endsection
