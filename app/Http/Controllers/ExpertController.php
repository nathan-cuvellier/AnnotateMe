<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Annotation;
use App\Category;
use App\Competencelevel;
use App\Data;
use App\Date;
use App\Expert;
use App\Interfaces;
use App\Participation;
use App\Project;
use App\SessionMode;
use App\Pairwise;
use App\Tripletwise;
use App\Http\Requests\ValidateLogin;
use App\Http\Requests\ValidateRegister;
use App\Http\Requests\ValidateExpertUpdate;


class ExpertController extends Controller
{
	public function register()
	{
		if (session()->get('typeExp') != NULL && (session()->get('typeExp') == "admin" || session()->get('typeExp') == "superadmin")) 
		{
			return view('expertRegister');
		}
        else
            return view('error_not_allowed');
	}

	public function get() {
		return $this->check(NULL, 'none');
	}

	public function post(ValidateLogin $request) {
		return $this->check($request->input('mail_exp'), $request->input('pwd_exp'));
	}

	public function check($mel, $motpasse) {

		$exp = Expert::where('mail_exp','ILIKE',$mel)->get();
		if($exp->count() != 1 )
			return view('expertLogin',['passError'=>'Wrong Password or Email']);
		else
		{
			$comdp = $exp->map(function ($exp) {
			return $exp->only(['pwd_exp']);
			});
			
			if (Hash::check($motpasse,$comdp[0]['pwd_exp'])) 
			{
				$idexp = $exp->map(function ($exp) {
					return $exp->only(['id_exp']);
				});
				$typeexp = $exp->map(function ($exp) {
					return $exp->only(['type_exp']);
				});


				/*if($idexp[0]['id_exp'] == session()->get("idExp"))
				{
					dd("cc");
				}*/

				session()->put("loginExp", $mel);
				session()->put("idExp", $idexp[0]['id_exp']);
				session()->put("typeExp", $typeexp[0]['type_exp']);

				return redirect('/projects');
			}
			else
			{
				return view('expertLogin',['passError'=>'Wrong Password or Email']);
			}
		}
	}




	public function logout(){
		session()->forget("loginExp");
		session()->forget("idExp");
		session()->forget("typeExp");
		return redirect('/');
	}

	public function login(){
		return view('expertLogin');
	}

	public function save(ValidateRegister $request)
	{

		$data = $request->except("_token");
		
		$data["pwd_exp"] = Hash::make($data["pwd_exp"]);
		$exp = Expert::create($data);

		return redirect('/projects');
	}

	public function list()
	{

		$allExpert = Expert::all();
		


		return view("expert_list",
			[
				"allExpert" => $allExpert,
			]);
	}

	public function update($idExp)
	{
		$expertToModify = Expert::find($idExp);

		return view('/expert_update',[
			'exp' => $expertToModify,
		]);
	}

	public function update_confirmed(ValidateExpertUpdate $request, $id)
	{	

		$exp = Expert::find($id);

		if($request->input("current_pwd_exp") != null)
		{
			if (Hash::check($request->input("current_pwd_exp"),$exp->pwd_exp)) 
			{
				if($request->input("new1_pwd_exp") === $request->input("new2_pwd_exp"))
				{
					$exp->update(['pwd_exp' => Hash::make($request->input("new1_pwd_exp"))]);
				}
			}
		}


		

		$name_exp = $exp->update(['name_exp' => $request->input("name_exp")]);
        $firstname_exp 	= $exp->update(['firstname_exp' => $request->input("firstname_exp")]);
        $bd_date_exp = $exp->update(['bd_date_exp' => $request->input("bd_date_exp")]);
        $sex_exp = $exp->update(['sex_exp' => $request->input("sex_exp")]);
        $address_exp = $exp->update(['address_exp' => $request->input("address_exp")]);
        $pc_exp = $exp->update(['pc_exp' => $request->input("pc_exp")]);
        $mail_exp = $exp->update(['mail_exp' => $request->input("mail_exp")]);
        $tel_exp = $exp->update(['tel_exp' => $request->input("tel_exp")]);
        $city_exp = $exp->update(['city_exp' => $request->input("city_exp")]);


		return redirect('/list');
	}

	public function delete_expert($idExp)
	{
		$del_expert = Expert::whereIn('id_exp',[$idExp])->delete();
		$del_annotation = Annotation::whereIn('id_exp',[$idExp])->delete();
		$del_pairwise = Pairwise::whereIn('id_exp',[$idExp])->delete();
		$del_participation = Participation::whereIn('id_exp',[$idExp])->delete();
		$del_project = Project::whereIn('id_exp',[$idExp])->delete();
		$del_triplewise = Tripletwise::whereIn('id_exp',[$idExp])->delete();

		session()->put('message','The expert has been deleted.');

		return redirect('/list');
	}
}