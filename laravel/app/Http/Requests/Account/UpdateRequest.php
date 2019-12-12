<?php

namespace App\Http\Requests\Account;

use App\Expert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return 403 if expert try to update an other expert
        if (session('expert')['type'] == "expert" && session('expert')['id'] != session('expert')['id'])
            return false;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $expert = Expert::find($this->route('id'));


        Validator::extend('check_hashed_pass', function ($attribute, $value, $parameters) {
            return Hash::check($value, $parameters[0]);
        });

        $rules = [
            'name_exp' => 'required|min:5|max:50',
            'firstname_exp' => 'required|min:5|max:50',
            'bd_date_exp' => 'required',
            'sex_exp' => 'required|in:man,woman',
            'type_exp' => 'required|in:admin,expert',
            'address_exp' => 'required|max:50',
            'pc_exp' => 'required|min:5|max:10',
            'mail_exp' => 'required|email|max:50',
            'tel_exp' => 'required|max:50',
            'city_exp' => 'required|max:50',
            'pwd_exp' => 'nullable|confirmed',
        ];

        if($expert->type_exp == 'superadmin')
            $rules['type_exp'] .= ',superadmin';

        if ($this->request->get('mail_exp') != $expert->mail_exp)
        	$rules['mail_exp'] .= '|unique:expert,mail_exp';

        if($this->request->get('tel_exp') != $expert->tel_exp)
        	$rules['tel_exp'] .= '|unique:expert,tel_exp';

        if (session('expert')['type'] == 'expert') 
        	$rules['current_pwd_exp'] = 'check_hashed_pass:' . $expert->pwd_exp;

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
            'name_exp' => 'name',
            'firstname_exp' => 'firstname',
            'bd_date_exp' => 'birthday',
            'sex_exp' => 'sex',
            'type_exp' => 'type',
            'address_exp' => 'address',
            'pc_exp' => 'postal code',
            'mail_exp' => 'mail',
            'tel_exp' => 'phone number',
            'city_exp' => 'city',
            'pwd_exp' => 'password',
        ];
    }

    /**
     * Create custom message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_pwd_exp.check_hashed_pass' => 'Bad password',
        ];
    }

}
