<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
// 'current_pwd_exp' => new CheckUpdatePwd($this->request->get('truePwd')),
class CheckUpdatePwd implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($truePwd)
    {
        $this->TruePwd = $truePwd;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // dd($this->TruePwd);

        // dd($value);
        // dd(Hash::check($value, $this->TruePwd));
        // dd(Hash::check( $this->TruePwd, $value));
        return Hash::check($value, $this->TruePwd);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Wrong PassWord';
    }
}
