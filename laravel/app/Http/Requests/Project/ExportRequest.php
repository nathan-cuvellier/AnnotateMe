<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
            'columExport' => 'required',
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
            'columExport' => 'column export',
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
            'columExport.required' => 'Check a export information is required',
        ];
    }
}
