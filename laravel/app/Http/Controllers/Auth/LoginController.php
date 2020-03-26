<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Expert;

class LoginController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        if(session()->has('expert'))
            return redirect()->route('project.list');

        return view('auth.login');
    }

    /**
     *
     *
     *
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function check(LoginRequest $request)
    {
        if(session()->has('expert'))
            return redirect()->route('project.list');

        $errorMessage = "Wrong Password or Email";
        $expert = Expert::where('mail_exp', $request->mail_exp)->first();


        /**
         * Email not found
         */
        if (!$expert) {
            $request->session()->flash('error', $errorMessage);
            return view('auth.login');
        }

        /**
         * Bad password
         */
        if(!Hash::check($request->pwd_exp, $expert->pwd_exp)){
            $request->session()->flash('error', $errorMessage);
            return view('auth.login');
        }

        session()->put("expert", ['id' => $expert->id_exp, 'email' => $expert->mail_exp, 'type' => $expert->type_exp, 'firstname' => $expert->firstname_exp, 'name' => $expert->name_exp]);
        return redirect()->route('project.list');
    }
}
