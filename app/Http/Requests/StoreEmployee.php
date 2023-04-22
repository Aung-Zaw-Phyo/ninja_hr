<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
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
        return [
            "employee_id" => 'required',
            "name" => 'required',
            "phone" => 'required',
            "email" => 'required',
            "nrc_number" => 'required',
            "gender" => 'required',
            "birthday" => 'required',
            "department_id" => 'required',
            "date_of_join" => 'required',
            "is_present" => 'required',
            "address" => 'required',
            "password" => 'required',
        ];
    }
}
