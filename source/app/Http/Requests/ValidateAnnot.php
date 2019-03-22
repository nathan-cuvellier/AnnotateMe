<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAnnot extends FormRequest
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
            'cat' => 'required',
            'confiance' => 'required',
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
        'cat.required' => 'A category is required.',
        'confiance.required' => 'A confidence level is required.',
    ];
}
}
