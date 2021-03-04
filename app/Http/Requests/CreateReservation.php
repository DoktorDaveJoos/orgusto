<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReservation extends FormRequest
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

    public function messages()
    {
        return [
            'start' => 'A date for the reservation is required',
            'persons.required' => 'Persons is required',
            'user_id.required' => 'Employee is required',
            'duration.required' => 'Duration of the reservation is required',
            'name.required' => 'Title or name of the reservation is required',
            'phone_number' => 'Phone number should be phone number.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start' => 'required|date',
            'persons' => 'required',
            'user_id' => 'integer|required',
            'duration' => 'required',
            'tables' => 'array|required',
            'name' => 'required',
            'email' => 'nullable|email',
            'color' => [Rule::in(['gray', 'indigo', 'blue', 'green', 'red', 'orange', 'w'])],
            'notice' => 'max:255',
            'phone_number' => 'max:15',
            'done' => 'boolean'
        ];
    }
}
