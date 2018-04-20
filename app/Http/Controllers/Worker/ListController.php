<?php

namespace App\Http\Controllers\Worker;

use App\Worker;
use Illuminate\Support\Facades\Auth;

class ListController
{
    function index() {
        $owner = Auth::user();
        $workers = $owner->workers()->orderBy('name')->get();

        return view('workers.list', ['workers' => $workers]);
    }
}