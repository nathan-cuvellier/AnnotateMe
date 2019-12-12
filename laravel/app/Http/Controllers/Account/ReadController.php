<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expert;

class ReadController extends Controller
{
    //
    public function view($id)
    {
        $expert = Expert::find($id);


        if (is_null($expert) && session('expert')['type'] != "expert")
            return redirect()->route('account.list')->with('warning', "Account n°$id not found");
        else if (is_null($expert))
            return abort(404);


        if ($expert->id_exp != session('expert')['id'] && ($expert->type_exp == session('expert')['type']
                || session('expert')['type'] == "expert" && $expert->type_exp != session('expert')['type'] // expert is not allow to see an other account
                || session('expert')['type'] == "admin" && $expert->type_exp == "superadmin"
            )) {
            return abort(403);
        }

        return view('account.CRUD.read', ['expert' => $expert]);
    }
}
