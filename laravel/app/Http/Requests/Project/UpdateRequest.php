<?php

namespace App\Http\Requests\Project;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $project = Project::findOrFail($this->route('id'));

        $rules = [
            'name_prj' => 'required|string|max:40|regex:/^[a-zA-Z0-9_ ]*$/',
            'desc_prj' => 'nullable|string|max:500',
            'id_mode' => 'required|integer',
            'limit_prj' => 'required|integer',
            'waiting_time_prj' => 'required|integer|min:0',
        ];

        // check the constraint if expert change the name of project
        if ($this->request->get('name_prj') != $project->name_prj)
            $rules['name_prj'] .= '|unique:project,name_prj';


        return $rules;
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
