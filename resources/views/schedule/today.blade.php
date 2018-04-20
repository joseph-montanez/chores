@extends('layouts.app')

@section('styles')
    <style type="text/css">
        li.list-group-item.done {
            text-decoration: line-through;
            color: silver;
        }
        li.list-group-item input[type=checkbox] {
            margin: 0;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        Today's Schedule <span class="float-right">{{ @date(now()) }}</span>
                    </div>

                    @include('shared.flash')

                    @if ($works->count() === 0)
                        <div class="card-body text-center text-muted">
                            You have no work right now!
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @verbatim
                                <li class="list-group-item"
                                    v-for="(work, index) in works"
                                    v-bind:class="{done: work.completed == 1}">
                                    <label class="work">
                                        <input type="checkbox" v-bind:value="1" v-bind:checked="work.completed == 1" v-on:change="toggleDone(index)">
                                        {{ work.name }} at {{ work.due_time }}
                                    </label>
                                </li>
                            @endverbatim
                        </ul>
                    @endif

                    <div class="card-footer text-center">
                        <a class="btn btn-primary" href="{{ route('chore.add.index') }}">Add Chore</a>
                    </div>
                </div>

                <div class="text-center">
                    <a class="btn btn-link" href="{{ route('schedule.print.week') }}">Weekly Print Out</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var works = {!! $works !!};
    </script>
    <script src="{{@full_asset('/js/chores/manifest.js')}}"></script>
    <script src="{{@full_asset('/js/chores/vendor.js')}}"></script>
    <script src="{{@full_asset('/js/chores/schedule.today.js')}}"></script>
@endsection
