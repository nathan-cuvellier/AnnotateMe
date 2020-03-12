<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'name_exp' => 'required|min:5|max:50',
            'firstname_exp' => 'required|min:5|max:50',
            'bd_date_exp' => 'required',
            'sex_exp' => 'required|in:man,woman',
            'type_exp' => 'required|in:admin,expert',
            'address_exp' => 'required|max:50',
            'pc_exp' => 'required|min:5|max:10',
            'mail_exp' => 'required|email|max:50|unique:expert,mail_exp',
            'tel_exp' => 'required|max:50|unique:expert,tel_exp',
            'city_exp' => 'required|max:50',
            'pwd_exp' => 'required|confirmed|min:3',
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
            'pwd_exp.confirmed' => 'The password confirmation does not match.',
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
}
