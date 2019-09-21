<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateRegister extends FormRequest
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
            'name_exp' => 'required',
            'firstname_exp' => 'required',
            'type_exp' => 'required',
            'bd_date_exp' => 'required|before:today',
            'sex_exp' => 'required',
            'address_exp' => 'required',
            'pc_exp' => 'required',
            'city_exp' => 'required',
            'mail_exp' => 'required|unique:expert|email',
            'tel_exp' => 'required',
            'pwd_exp' => 'required',
            'conf_pwd_exp' => 'same:pwd_exp|required'

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
            //Request

            'name_exp.required' => 'A name is required.',
            'firstname_exp.required' => 'A firstname is required.',
            'type_exp.required' => 'The type of the expert is required.',
            'bd_date_exp.required' => 'A birth date is required.',
            'sex_exp.required' => 'The sex is required.',
            'address_exp.required' => 'An address is required.',
            'pc_exp.required' => 'A postal code is required.',
            'city_exp.required' => 'A city is required.',
            'mail_exp.required' => 'An email is required.',
            'tel_exp.required' => 'A phone number is required.',
            'pwd_exp.required' => 'A password is required.',
            'conf_pwd_exp' => 'A confirmation password is required',

            //Mail
            'mail_exp.unique' => 'This email is already used.',
            'mail_exp.email' => 'You must enter a valid email.',

            //bd_date
            'bd_date_exp.before' => 'You must enter a valid date of birth.',

            //conf
            'conf_pwd_exp.same' => 'The 2 passwords are different'

        ];
    }
}
