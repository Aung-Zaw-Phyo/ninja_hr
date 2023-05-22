<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalary extends FormRequest
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
        $id = $this->route('employee');
        return [
            "user_id" => 'required',
            "amount" => 'required',
            "month" => 'required',
            "year" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Employee field is required.'
        ];
    }
}
