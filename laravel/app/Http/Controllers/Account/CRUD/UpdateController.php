<?php

namespace App\Http\Controllers\Account\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\Account\UpdateRequest;
use App\Expert;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|void
     */
    public function view($id)
    {
        $listTypeExpert = ['expert', 'admin', 'superadmin'];
        $listSexExpert = ['man', 'woman'];

        // if expert try to update a other account
        if (session('expert')['type'] == "expert" && session('expert')['id'] != $id)
            return abort(403); // In order not to reveal the ids of existing accounts, always return a 403, if the user connected is of type expert

        $expert = Expert::find($id);

        // if id no matches with an expert
        if (is_null($expert) && session('expert')['type'] != "expert")
            return redirect()->route('account.list')->with('warning', "Account n°$id not found");
        else if (is_null($expert))
            return abort(403);// In order not to reveal the ids of existing accounts, always return a 403, if the user connected is of type expert

        // check if expert                      
        if($expert->id_exp != session('expert')['id'] && $expert->type_exp == session('expert')['type'])
            return redirect()->route('account.list')->with('warning', 'You do not have the right to change an account of the same level as you');

        return view('account.CRUD.update', ['expert' => $expert, 'listTypeExpert' => $listTypeExpert, 'listSexExpert' => $listSexExpert]);
    }

    /**
     * @param $id
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UpdateRequest $request)
    {
        $expert = Expert::findOrFail($id);
        $data = $request->except('_token');

        if(!isset($data['pwd_exp']))
            unset($data['pwd_exp']);
        else
            $data['pwd_exp'] = Hash::make($data['pwd_exp']);

        if (session('expert')['type'] == "expert") {
            if(Hash::check($data['current_pwd_exp'], $expert->pwd_exp))
                $expert->update($data);
        }
        else
            $expert->update($data);

        return redirect()->route('account.list');
    }
}