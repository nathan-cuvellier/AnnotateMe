<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUpdateProject extends FormRequest
{
    /**
     * Dertermine si l'utilisateur est autorisé à valider le formulaire
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Définie les conditions de validation du formulaire
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_prj' => 'required',
            'desc_prj' => '',
            'id_mode' => 'required',
            'limit_prj' => 'required|numeric',
        ];
    }

    /**
     * Définie les messages personnalisés d'erreur
     *
     * @return array
     */
    public function messages()
    {
        return [
            //Required
            'name_prj.required' => 'A name is required.',
            'desc_prj.required' => 'A description is required.',
            'id_mode.required' => 'An annotation mode is required.',
            'limit_prj.required' => 'A limit value is required.',

            //Numeric
            'limit_prj.numeric' => 'The limit must be a numeric value.',
            
        ];
    }
}
