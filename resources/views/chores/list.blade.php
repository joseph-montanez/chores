@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <div class="card">
                    <div class="card-header">All Chores</div>

                    @include('shared.flash')

                    <div class="card-body text-muted">
                        Here is a list of chores to manage. Each chore generates "work" which is then assigned to a
                        worker. This work is what you see in Today's Schedule.
                    </div>

                    @if ($tasks->count() === 0)
                        <div class="well-sm">
                            <p class="text-center text-info">You have no chores, why not add one?</p>
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($tasks as $task)
                                <li class="list-group-item">
                                    <a href="{{ route('chore.view.index', ['id' => $task->id]) }}">
                                        @if ($task->is_repeating > 1)
                                            <span class="glyphicon glyphicon-repeat"></span>
                                        @endif
                                        {{$task->name}}
                                    </a>

                                    <a class="btn btn-xs btn-link text-danger float-right" style="margin-left: 10px"
                                       onclick="return confirm('Are you sure you want to delete this chore?')"
                                       href="{{ route('chore.delete', ['id' => $task->id]) }}">
                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                    </a>

                                    <a class="btn btn-xs btn-default float-right" href="{{ route('chore.edit.index', ['id' => $task->id]) }}">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                        Edit Chore
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="card-body">
                        {{ $tasks->links() }}
                    </div>

                    <div class="card-footer text-center">
                        <a class="btn btn-primary" href="{{ route('chore.add.index') }}">Add Chore</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
