<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreChore extends FormRequest
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
        $rules = [
            'name' => 'required',
            'start_at_date' => 'required|date',
            'start_at_time.hh' => 'required|date_format:"g"',
            'start_at_time.mm' => 'required|date_format:"i"',
            'start_at_time.A' => 'required|date_format:"A"',
            'workers' => 'required',
        ];

        if ((int) $this->get('reoccurring', 0) === 1) {
            $rules = array_merge($rules, [
                'end_at_date' => 'date|after:start_at',
                'end_at_time.hh' => 'date_format:"g"',
                'end_at_time.mm' => 'date_format:"i"',
                'end_at_time.A' => 'date_format:"A"',
                'frequency' => 'required|integer',
                'interval' => 'required|integer',
                'count' => 'integer',
            ]);
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_at_date.required' => 'A start date is required',
            'start_at_time.hh.required' => 'A start time hour is required',
            'start_at_time.mm.required' => 'A start time minute is required',
            'start_at_time.A.required' => 'A start time meridiem (AM/PM) is required',
        ];
    }
}
