<?php

namespace App\Http\Controllers\Account;

use App\Category;
use App\Data;
use App\Expert;
use App\Http\Controllers\Controller;
use App\Participation;
use Illuminate\Http\Request;
use App\Http\Middleware\HighGrade;

class DeleteController extends Controller
{

    /**
     * DeleteController constructor.
     */
    public function __construct()
    {
        //$this->middleware('HighGrade');
    }

    public function delete($id){
        $expert = Expert::find($id);

        if(session('expert')['type'] == "expert" && $expert->type_exp != "expert")
            return redirect()->route('account.list')->with('warning', 'You do not have the right to delete an other account');

        if(session('expert')['id'] != $expert->id_exp && session('expert')['type'] == $expert->type_exp)
            return redirect()->route('account.list')->with('warning', 'You do not have the right to delete an account of the same level as you');

        if($expert->type_exp == "superadmin")
            return redirect()->route('account.list')->with('warning', 'Prohibition to delete a superadmin account');


        if(session('expert')['id'] == $expert->id_exp)
            session()->forget('expert');

        Participation::query()
            ->where('id_exp',$id)
            ->delete();

        Expert::find($id)
            ->delete();

        return redirect()->route('project.list')->with('success','Account deleted with success !');
    }

}
