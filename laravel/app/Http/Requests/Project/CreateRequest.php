<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * The min and max correspond at the constraints in database
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_prj' => 'required|string|max:40|unique:project,name_prj|regex:/^[a-zA-Z0-9_ ]*$/',
            'desc_prj' => 'nullable|string|max:500',
            'id_mode' => 'required|integer',
            'id_int' => 'required|integer',
            'limit_prj' => 'required|integer',
            'waiting_time_prj' => 'required|integer|min:0',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name_prj' => 'name',
            'desc_prj' => 'description',
            'id_mode' => 'mode',
            'id_int' => 'interface',
            'limit_prj' => 'limit',
            'waiting_time_prj' => '',
        ];
    }



}
