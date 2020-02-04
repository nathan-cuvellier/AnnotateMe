<?php

namespace App\Http\Controllers\Account\CRUD;

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

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $expert = Expert::findOrFail($id);

        // If user is an expert and it try to delete an account which isn't expert type
        if(session('expert')['type'] == "expert" && $expert->type_exp != "expert")
            return redirect()->route('account.list')->with('warning', 'You do not have the right to delete an other account');

        // If the user try to delete another account than his own which has the same level (same type of expert)
        if(session('expert')['id'] != $expert->id_exp && session('expert')['type'] == $expert->type_exp)
            return redirect()->route('account.list')->with('warning', 'You do not have the right to delete an account of the same level as you');

        // By security is not possible to delete an superadmin directly in website
        if($expert->type_exp == "superadmin")
            return redirect()->route('account.list')->with('warning', 'Prohibition to delete a superadmin account');

        /*
         * Unset var 'expert' in session
         * After the redirect, thanks to the middleware 'CheckConnected', the user will redirect automatically in login page
         */
        if(session('expert')['id'] == $expert->id_exp)
            session()->forget('expert');

        $expert->update([
            'name_exp' => NULL,
            'firstname_exp' => NULL,
            'bd_date_exp' => NULL,
            'sex_exp' => NULL,
            'address_exp' => NULL,
            'pc_exp' => NULL,
            'mail_exp' => NULL,
            'tel_exp' => NULL,
            'city_exp' => NULL,
            'pwd_exp' => NULL,
        ]);
        
        /*
        Participation::query()
            ->where('id_exp',$id)
            ->delete();

        Expert::find($id)
            ->delete();
        */

        return redirect()->route('project.list')->with('success','Account deleted with success !');
    }

}
