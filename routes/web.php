<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Notifications\WorkReminder;
use App\Work;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\Pushover\PushoverChannel;
use Recurr\Frequency;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/schedule/today');

    }
    return view('welcome');
});

Route::get('/test-pushover', function () {
    /**
     * @var PushoverChannel
     */
    $pushover = $this->app->make(PushoverChannel::class);

    $task = new App\Task();
    $task->name = 'Automated Test';

    $work = new Work();
    $work->task = $task;

    $notification = new WorkReminder($work);

    $pushover->send(Auth::user(), $notification);
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('/api/chores', 'Api\ChoreController');

    Route::group(['namespace' => 'Chore'], function () {
        Route::get('/chores/add', 'AddController@index')->name('chore.add.index');
        Route::post('/chores/add', 'AddController@store')->name('chore.add.store');

        Route::get('/chores/list', 'ListController@index')->name('chore.list');
        Route::get('/chores/delete/{id}', 'DeleteController@index')->name('chore.delete');

        Route::get('/chores/edit/{id}', 'EditController@index')->name('chore.edit.index');
        Route::post('/chores/edit/{id}', 'EditController@store')->name('chore.edit.store');

        Route::get('/chores/view/{id}', 'ViewController@index')->name('chore.view.index');
        Route::get('/schedule/today', 'ScheduleController@today')->name('schedule.today');
        Route::get('/work/complete/{id}', 'ScheduleController@markDone')->name('work.complete');
        Route::get('/work/incomplete/{id}', 'ScheduleController@markNotDone')->name('work.incomplete');

        Route::get('/schedule/print/week', 'ViewController@print')->name('schedule.print.week');

    });

    Route::group(['namespace' => 'Worker'], function () {
        Route::get('/workers/add', 'AddController@index')->name('worker.add.index');
        Route::post('/workers/add', 'AddController@store')->name('worker.add.store');

        Route::get('/workers/list', 'ListController@index')->name('worker.list');
        Route::get('/workers/delete/{id}', 'DeleteController@index')->name('worker.delete');

        Route::get('/workers/edit/{id}', 'EditController@index')->name('worker.edit.index');
        Route::post('/workers/edit/{id}', 'EditController@store')->name('worker.edit.store');

        Route::post('/workers/view/{id}', 'ViewController@store')->name('worker.view.index');
    });
});


Route::get('/chore/add', function () {
//    $task = App\Task::first();

    $task = new \App\Task();
    $task->start_at = (new \DateTime('now'))->format('Y-m-d H:i:s');
    $task->end_at = (new \DateTime('now +1 week'))->format('Y-m-d H:i:s');
    $task->timezone = 'America/Los_Angeles';
    $task->frequency = Frequency::DAILY;
    $task->interval = 1;
    $task->count = 0;
    $task->save();

    $recurr = $task->recurr();
    dd($recurr->schedule());

});


Route::get('/worker/test', function () {
    $owner = \App\User::first();
    $worker = \App\Worker::first();
    $user = \App\User::find(2);

    $owner->workers()->attach($user);

    dd($owner->workers()->get()->all());


    dd();
    $owner = \App\User::find(1);
    $user = \App\User::find(2);
    $worker = new \App\Worker();
    $worker->owner()->associate($owner);
    $worker->user()->associate($user);
    $worker->save();
});


Route::get('/pdf/test', 'Chore\ViewController@print');

Route::get('/elm-chores', function () {
    return view('chores.list2');
});

Route::post('api/v1/user/signup', 'Auth\RegisterController@register')->name('api.v1.user.signup');
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('api/v1/schedule/today', 'Chore\ScheduleController@today')->name('api.v1.schedule.today');
});

Route::prefix('api/v1')->group(function () {

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('schedule/today', 'Chore\ScheduleController@today')->name('api.v1.schedule.today');
        Route::get('users/me', 'Api\UserController@me')->name('api.v1.user.me');

        //-- Users
        Route::get('users', 'Api\UserController@list')->name('api.v1.user.list');
        Route::post('users', 'Api\UserController@create')->name('api.v1.user.create');
        Route::get('users/{id}', 'Api\UserController@get')->name('api.v1.user.get');
        Route::put('users/{id}', 'Api\UserController@update')->name('api.v1.user.update');

        //-- Workers
        Route::post('workers', 'Api\WorkerController@create')->name('api.v1.worker.create');
        Route::get('workers', 'Api\WorkerController@list')->name('api.v1.worker.list');
        Route::get('workers/{id}', 'Api\WorkerController@get')->name('api.v1.worker.get');
        Route::put('workers/{id}', 'Api\WorkerController@update')->name('api.v1.worker.update');
    });
});

Route::get('/sms', function () {
    $work = Work::inRandomOrder()->first();
    $task = $work->task;
    $worker = $work->worker;
    $service = new \App\Task\WorkService();
    dd($service->createNotice($worker, $work));
});