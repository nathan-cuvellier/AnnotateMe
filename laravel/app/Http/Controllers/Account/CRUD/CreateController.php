<?php

namespace App\Http\Controllers\Account\CRUD;

use App\Expert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CreateRequest;
use Illuminate\Support\Facades\Hash;

class CreateController extends Controller
{
    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        $this->middleware('HighGrade'); // just accessible for admin or superadmin
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        // Constraint in expert table
        $listTypeExpert = ['expert', 'admin']; // An superadmin can't create directly in website by security
        $listSexExpert = ['man', 'woman'];
        return view('account.CRUD.create', ['listTypeExpert' => $listTypeExpert, 'listSexExpert' => $listSexExpert]);
    }

    /**
     * Create an account in expert table after fill a form
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(CreateRequest $request)
    {
        $data = $request->except('_token'); // unset useless information

        $data['pwd_exp'] = Hash::make($data['pwd_exp']);
        $exp = Expert::create($data); // insert expert in expert table
        return redirect()->route('project.list')->with('success', 'Account created with success !');
    }
}
