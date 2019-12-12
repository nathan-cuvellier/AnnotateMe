<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Expert;
use App\Http\Requests\Account\RegisterRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        $this->middleware('HighGrade');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $listTypeExpert = ['expert', 'admin'];
        $listSexExpert = ['man', 'woman'];
        return view('auth.register', ['listTypeExpert' => $listTypeExpert, 'listSexExpert' => $listSexExpert]);
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->except('_token');

        $data['pwd_exp'] = Hash::make($data['pwd_exp']);
        $exp = Expert::create($data);
        return redirect()->route('project.list')->with('success','Account created with success !');
    }
}
