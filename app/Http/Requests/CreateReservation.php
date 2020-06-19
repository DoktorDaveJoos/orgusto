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
            'starting_at' => 'A date for the reservation is required',
            'person_count.required' => 'Persons is required',
            'user_id.required' => 'Employee is required',
            'length.required' => 'Duration of the reservation is required',
            'name.required' => 'Title or name of the reservation is required',
            'phone_number' => 'Phone number should be phone number.'
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
            'starting_at' => 'required|date',
            'person_count' => 'required',
            'user_id' => 'integer|required',
            'length' => 'required',
            'tables' => 'array|required',
            'name' => 'required',
            'email' => 'email',
            'color' => [Rule::in(['gray', 'indigo', 'blue', 'green', 'red', 'orange'])],
            'notice' => 'max:255',
            'phone_number' => 'alpha_num'
        ];
    }
}