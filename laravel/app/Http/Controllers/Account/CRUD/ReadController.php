<?php

namespace App\Http\Controllers\Account\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expert;

class ReadController extends Controller
{
    /**
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|void
     */
    public function view($id)
    {
        $expert = Expert::find($id);

        if (is_null($expert) && session('expert')['type'] != "expert")
            return redirect()->route('account.list')->with('warning', "Account n°$id not found");
        else if (is_null($expert))
            return abort(403); // In order not to reveal the ids of existing accounts, always return a 403, if the user connected is of type expert

        if ($expert->id_exp != session('expert')['id'] && ($expert->type_exp == session('expert')['type'] // If the user try to read another account than his own which has the same level (same type of expert)
                || session('expert')['type'] == "expert" && $expert->type_exp != session('expert')['type'] // user of type expert is not allowed to see an other account than his own
                || session('expert')['type'] == "admin" && $expert->type_exp == "superadmin" // user of type admin is not allowed to see an account of type superadmin
            )) {
            return abort(403);
        }

        return view('account.CRUD.read', compact('expert'));
    }
}
