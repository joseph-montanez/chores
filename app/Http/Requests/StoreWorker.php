<?php

namespace App\Http\Requests;

use App\Worker;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorker extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $worker_id = $this->route('id');
        if ($worker_id) {
            $worker = Worker::findOrFail($worker_id);
            $user = $worker->user;
            return [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,' . $user->id,
            ];
        } else {
            return [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ];
        }
    }
}
