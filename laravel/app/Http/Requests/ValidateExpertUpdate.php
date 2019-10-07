<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckUpdatePwd;

class ValidateExpertUpdate extends FormRequest
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
            'pc_exp' => 'required|numeric',
            'city_exp' => 'required',
            'mail_exp' => 'required|email',
            'tel_exp' => 'required',
            'new1_pwd_exp' => 'same:new2_pwd_exp|required_with:new2_pwd_exp|required_with:current_pwd_exp',
            'new2_pwd_exp' => 'same:new1_pwd_exp|required_with:new1_pwd_exp|required_with:current_pwd_exp',
            'current_pwd_exp' => [new CheckUpdatePwd($this->truePwd),'required_with:new1_pwd_exp|required_with:new2_pwd_exp'],
            

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
            'pc_exp.required' => 'A PC is required.',
            'city_exp.required' => 'A city is required.',
            'mail_exp.required' => 'An email is required.',
            'tel_exp.required' => 'A phone number is required.',

            //Mail
            'mail_exp.email' => 'You must enter a valid email.',

            //bd_date
            'bd_date_exp.before' => 'You must enter a valid date of birth.',

            //CP
            'pc_exp.numeric' => 'The postal code must be a numeric value.',

            //Password
            'new1_pwd_exp.same' => 'The 2 given password are different.',
            'new2_pwd_exp.same' => 'The 2 given password are different.',

            //required_with
            'new1_pwd_exp.required_with' => 'Required to change your password.',
            'new2_pwd_exp.required_with' => 'Required to change your password.',
            'current_pwd_exp.required_with' => 'Required to change your password.',
        ];
    }
}
