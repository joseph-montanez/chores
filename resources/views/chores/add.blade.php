@extends('layouts.app')

@section('content')
    <br>
    <chore id="add-chore"></chore>
@endsection

@section('scripts')
    <script type="text/javascript">
        var chore = @json($task);
        var workers = @json($workers);
        var task_workers = @json($task->workers()->get());
        var selected_workers = task_workers.reduce(function (result, task_worker) {
            result.push(task_worker.worker_id);

            return result;
        },[]);
        if (!chore.reoccurring && selected_workers.length > 0) {
            selected_workers = selected_workers[0];
        }
    </script>
    <script src="{{@full_asset('/js/chores/manifest.js')}}"></script>
    <script src="{{@full_asset('/js/chores/vendor.js')}}"></script>
    <script src="{{@full_asset('/js/chores/add.js')}}"></script>
@endsection
