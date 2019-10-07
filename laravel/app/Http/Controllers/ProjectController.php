<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
use App\Http\Requests\ValidateCreateProject;
use App\Http\Requests\ValidateUpdateProject;
use Illuminate\Support\Facades\Storage;



/*
===================
	CONTROLLER
===================

Controls all aspects of the project : Creation / Update / Delete / display / ...
*/

class ProjectController extends Controller
{
	protected $arrayDebug = array();



	/* List :
		Param : X
		Return : view (project_list_page)
	*/

	public function list(Request $request)
	{
		$search = \Request::get('search'); //Get search term value
		$interface = \Request::get('interface'); //Get interface term value
		$session_mode = \Request::get('session_mode'); //Get session_mode term value

		if ($interface == null) {
			$interface = "all";
		}
		if ($session_mode == null) {
			$session_mode = "all";
		}
		// Projects where the user participates
		$particitionProject = Participation::whereIn("id_exp",[session()->get('idExp')])->get();

		if($search != null || $interface != "all" || $session_mode != "all") {
			if($interface != "all" && $session_mode != "all")
				$projects_searched = Project::where('name_prj','ILIKE', "%$search%")->where('id_int','=',$interface)->where('id_mode','=',$session_mode)->get(); //If search term exists, search project name wich contain this
			else if($interface != "all" && $session_mode == "all")
				$projects_searched = Project::where('name_prj','ILIKE', "%$search%")->where('id_int','=',$interface)->get(); //If search term exists, search project name wich contain this
			else if($interface == "all" && $session_mode != "all")
				$projects_searched = Project::where('name_prj','ILIKE', "%$search%")->where('id_mode','=',$session_mode)->get(); //If search term exists, search project name wich contain this
			else 
				$projects_searched = Project::where('name_prj','ILIKE', "%$search%")->get();

			//We only count the projects found with those the user has access
			$count_participating_projects_searched = 0;
			foreach ($particitionProject as $aParticipation) {
				foreach ($projects_searched as $one_project_searched){
					if($aParticipation->id_prj == $one_project_searched->id_prj)
						$count_participating_projects_searched +=1;
				}
			}
			session()->put('message',$count_participating_projects_searched.' projects found'); //message on list page
			if ($count_participating_projects_searched==0){ //If search term correspond to nothing, return page like no research
				$search = null; //Destroy search term value
				$interface = "all";
				$session_mode = "all";
			}	
		}

		// Admin/SuperAdmin connected
		if (session()->get('typeExp') != NULL && (session()->get('typeExp') == 'superadmin' || session()->get('typeExp') == 'admin')){
			if($search != null || $interface != "all" || $session_mode != "all"){
				foreach ($projects_searched as $one_project_searched){
					$projects[] = Project::find($one_project_searched->id_prj);
				}
			}else{
				$projects = Project::All();
			}
		// Expert connected
		}else{
			foreach ($particitionProject as $aParticipation) {
				if($search != null || $interface != "all" || $session_mode != "all"){
					foreach ($projects_searched as $one_project_searched){
						if($aParticipation->id_prj == $one_project_searched->id_prj)
							$projects[] = Project::find($aParticipation->id_prj);
					}
				}else{
					$projects[] = Project::find($aParticipation->id_prj);
				}
			}
		}

		// If the user participate at any project 
		if(count($particitionProject) == 0)
		{
			$projects = array();
			session()->put('message','You do not have access to any project'); //message on list page
		}else{
			//Sort the list by ID
			for($i = count($projects) - 2; $i >= 0; $i--){
				for($j = 0; $j <= $i; $j++){
					if($projects[$j + 1]->id_prj < $projects[$j]->id_prj){
						$list = $projects[$j+1];
						$projects[$j+1] = $projects[$j];
						$projects[$j] = $list;
					}
				}
			}
		}

		/* if the expert leaves the annotation interface => Removes the annotation limit */
		if(session()->has('nb_annot_limit'))
			session()->forget('nb_annot_limit');

		 return view ("project_list_page", 
					 [
						"projects"=> $projects,
						"modes"=> SessionMode::All(),
						"particitionProject"=>$particitionProject,
						"listeInterfaces"=> Interfaces::all(),
					 ]);


	}

	    /* Page to show details of project / update / start annotation session */
	    public function details(Request $request, $id)
	    {
	        $part = Participation::whereIn('id_prj',[$id])->whereIn('id_exp',[session()->get('idExp')])->get();

	        

	        if($part->isEmpty()){
	           dd("Access DENIED");
	        }
	        
	       	$part[0]->expert_project_confidence_level = $request->input('confiance');
	       	$part[0]->save();
	     	return view ("project_details_page", 
	     				[
	     					'projects'=>Project::all(), 
	     					'project'=>Project::find($id),
	     					"category"=> Category::all(), 
	     					"expert"=> Expert::all(),
	     					"listeInterfaces"=> Interfaces::all(),
	     					"listeModes" => SessionMode::all()
	     				]);
	    }


	    /* Page with the parameters of a project wich we can changed */
	    public function update($id)
	    {
	        $allExpertNoAdmin = Expert::whereIn("type_exp",["expert"])->get();
	        $allParticipation = Participation::where("id_prj",[$id])->get();
	        $ExperPart = collect();

	        foreach ($allParticipation as $aPart) {
	        	$ExperPart->push(Expert::find($aPart->id_exp));
	        }

	        $i=0;
	        foreach ($allExpertNoAdmin as $aExpNoAdmin) {
	        	
        		if($ExperPart->contains($aExpNoAdmin))
	        	{
	        		$allExpertParticipation[$i] = array($aExpNoAdmin,true);
	        	}else
	        	{
	        		$allExpertParticipation[$i] = array($aExpNoAdmin,false);
	        	}
	        	$i++;
	        }

	        return view ("project_update_page", 
	                    [
	                        'projects'=> Project::all(), 
	                        'project'=> Project::whereIn('id_prj',[$id])->get(),
	                        "category"=> Category::all(), 
	                        "expert"=> Expert::all(),
	                        "listeModes"=> SessionMode::all(),
	                        "allExpertParticipation" => $allExpertParticipation,
							"listeInterfaces"=> Interfaces::all(),
	                    ]);
	    }

	    /* Update project parameters on database */
	     public function update_confirmed(ValidateUpdateProject $request, $id)
	    {
	        $prj = Project::find($id);
	        $name_ = $request->input('name_prj');
	        $desc_ = $request->input('desc_prj');
	        $mode_ = $request->input('id_mode');
	        $limit_ = $request->input('limit_prj');
	        $checkExpPart_ = $request->input("check_ExpList");
			if(!is_null(request()->file("datas")))
			{
				$file = request()->file("datas");
				$fileName = $file->getClientOriginalName();

				$path = "./source/storage/app/datas/";
				if(is_dir($path))
				{
					$datas = scandir($path);
					$nb = count($datas) + 1;
				}
				else
				{
					$nb = 0;
					mkdir($path, 0775, true);
					$datas = scandir($path);
				}

				if(strstr($fileName, ".zip") && !strstr($fileName, ".php"))
				{
					$file->storeAs('datas/'.$prj->name_prj, $fileName);
					$zip = new \ZipArchive;
					if ($zip->open($path.$prj->name_prj."/".$fileName) === TRUE)
					{
						$zip->extractTo($path.$prj->name_prj."/".strstr($fileName, ".", true));
						$zip->close();
					} 
					else 
					{
						dd($zip->open($path.$prj->name_prj."/".$fileName));
					}
					system("mv ".$path.substr($fileName,0,strlen($fileName)-4)." ".$path.$prj->name_prj.$fileName);

					system("rm ".$path.$fileName);

					$fileName = substr($fileName, 0, -4);
				}
				else
				{
					return view('', ["err"=>"Mauvais type de fichier"]);
				}

				$index = false;
				$this->analyzeDirectory($path.$prj->name_prj."/".$fileName."/", $index, $prj);
			}

	        $name = $prj->update(['name_prj' => $name_]);
	        $desc = $prj->update(['desc_prj' => $desc_]);
	        $mode = $prj->update(['id_mode' => $mode_]);
	        $limit = $prj->update(['limit_prj' => $limit_]);

	        $allParticipation = Participation::where("id_prj",[$id])->get();
	        $allExpertAdmin = Expert::whereIn("type_exp",["admin","superadmin"])->get(); 
	        foreach ($allParticipation as $aPart) {
	        	$aPart->delete();
	        }


	        foreach ($allExpertAdmin as $aAdmin) {
	        	$participation = new Participation;
		    	$participation->id_prj = $id;
		        $participation->id_cptlvl = 1;
		        $participation->id_exp = $aAdmin->id_exp;

		        $participation->save();
	        }

	        if($checkExpPart_!== null)
			{
				foreach ($request->input("check_ExpList") as $idExp) {
					$participation = new Participation;
			    	$participation->id_prj = $id;
			        $participation->id_cptlvl = 1;
			        $participation->id_exp = $idExp;

			        $participation->save();
				}
			}

			session()->put('message','The project has been updated'); //message on list page

	        return redirect('projects');
	    }

	    /* Function delete everything about the project */
	    public function delete_confirmed($id)
	    {
	    	/* Delete annotations */
	        $deldata = Data::whereIn('id_prj',[$id]);
	        foreach ($deldata->get() as $aData) {
	            Annotation::whereIn('id_data', [$aData->id_data])->delete();
	            Pairwise::whereIn('id_data1', [$aData->id_data])->delete();
	            Pairwise::whereIn('id_data2', [$aData->id_data])->delete();
	            Tripletwise::whereIn('id_data1', [$aData->id_data])->delete();
	            Tripletwise::whereIn('id_data2', [$aData->id_data])->delete();
	            Tripletwise::whereIn('id_data3', [$aData->id_data])->delete();
	        }

	        $deldata->delete();
			$delparticipation = Participation::whereIn('id_prj',[$id])->delete();
			$delcategory = Category::whereIn('id_prj',[$id])->delete();

			$projectToDelete = Project::whereIn('id_prj',[$id])->first();
			$prjDelPath = "datas/".$projectToDelete->name_prj."/";
			if(is_dir("./source/storage/app/".$prjDelPath))
			{
				Storage::deleteDirectory($prjDelPath);
			}
			$delproject = $projectToDelete->delete();

	        session()->put('message','The project has been deleted'); //message on list page
	        return redirect('/projects'); /* Return to the projects list page*/
	    }


	    /* Ask page to confirm the delete of the project */
	    public function delete($id)
	    {
	        return view ("project_delete_page", 
	                    [
	                        'projects'=> Project::all(), 
	                        'project'=> Project::whereIn('id_prj',[$id])->get(),
	                        "category"=> Category::all(), 
	                        "expert"=> Expert::all(),
	                    ]);
	    }


	    

   	//---------Function about a project---------------


		private function analyzeDirectory(String $pathParam, int $indexParam, Project $prjParam) {
			$dir = new \DirectoryIterator($pathParam);
			foreach ($dir as $file) {
				if($file->isDot()) continue;
				$lefichier = $pathParam."/".$file->getFilename();
				$this->arrayDebug[] = $lefichier;
				if($indexParam == false && $file->getFilename() == "categories.txt")
				{
					$indexParam = true;
					$categories = fopen($lefichier,"r");
					$text = fread($categories, filesize($lefichier));
					$lines = explode(PHP_EOL, $text);
					foreach($lines as $line)
					{
						$cat = new Category();
						$cat->label_cat = $line;
						$cat->id_prj = $prjParam->id_prj;
						$cat->save();
					}
					fclose($categories);
				} else {
					if(is_dir($lefichier))
					{
						$this->analyzeDirectory($lefichier, $indexParam, $prjParam);
					} else {
						$dataToAnnotate = new Data();
						$dataToAnnotate->id_prj = $prjParam->id_prj;
						$dataToAnnotate->pathname_data = substr($lefichier, -strlen($lefichier)+1);
						$dataToAnnotate->nbannotation_data = 0;
						$dataToAnnotate->save();

					}
				}
			}
		}



		public function save(ValidateCreateProject $request) {
			$data = $request->except('_token');
			
			$allAdmin = Expert::whereIn("type_exp",["superadmin","admin"])->get();

			//Standardizes the project name (no space and no MAJ)
			$data["name_prj"] = strtolower(str_replace(" ", "_",$request->input("name_prj")));

			$prj = Project::create($data);
			
			//Create table participation
			$currentUserMade = false;
			foreach ($allAdmin as $aAdmin) {
				$participation = new Participation;
		    	$participation->id_prj = $prj->id_prj;
		        $participation->id_cptlvl = 1;
		        $participation->id_exp = $aAdmin->id_exp;

		        $participation->save();
		        if($aAdmin->id_exp === session()->get('idExp'))
		        	$currentUserMade = true;
			}
			if($request->input("check_ExpList")!== null)
			{
				foreach ($request->input("check_ExpList") as $idExp) {
				$participation = new Participation;
		    	$participation->id_prj = $prj->id_prj;
		        $participation->id_cptlvl = 1;
		        $participation->id_exp = $idExp;


		        $participation->save();
				}
			}
			
			if(!$currentUserMade)
			{
				$participation = new Participation;
		    	$participation->id_prj = $prj->id_prj;
		        $participation->id_cptlvl = 1;
		        $participation->id_exp = session()->get('idExp');
		        $participation->save();
			}
			

			$path = "./source/storage/app/datas/";
			if(is_dir($path))
			{
				$datas = scandir($path);
				$nb = count($datas) + 1;
			}
			else
			{
				$nb = 0;
				mkdir($path, 0775, true);
				$datas = scandir($path);
			}
			
			$file = request()->file("datas");
			$fileName = $file->getClientOriginalName();

			if(strstr($fileName, ".zip") && !strstr($fileName, ".php"))
			{
				$file->storeAs('datas', $fileName);
				$zip = new \ZipArchive;
				if ($zip->open($path.$fileName) === TRUE)
				{
				    $zip->extractTo($path.strstr($fileName, ".", true));
				    $zip->close();
				} 
				else 
				{
				    dd($zip->open($path.$fileName));
				}
				system("mv ".$path.substr($fileName,0,strlen($fileName)-4)." ".$path.$prj->name_prj);
				system("rm ".$path.$fileName);

				$fileName = substr($fileName, 0, -4);
			}
			else
			{
				return view('', ["err"=>"Wrong file type"]);
			}

			$index = false;
			$this->analyzeDirectory($path.$prj->name_prj, $index, $prj);

			session()->put('message','The project has been created'); //message on list page
			return redirect('');
		}


		public function addProject(){
			$allExpertNoAdmin = Expert::whereIn("type_exp",["expert"])->get();

			session()->put('experts');
			return view('createProject',
						[
							"listeModes"=> SessionMode::all(), 
							"listeInterfaces"=> Interfaces::all(), 
							"allExpertNoAdmin"=>$allExpertNoAdmin
						]);
		
		}


		public function addProjectExp(Request $request){



			$listeModes = SessionMode::all();
			$listeInterfaces = Interfaces::all();

			$allExpert = Expert::all()->toArray();

			$exp = Expert::find($request->input('id_expAdd'));

			$expertProject = session()->get('experts');
			$expertProject[] = $exp;
			session()->put("experts", $expertProject);
			$expertList = array_udiff($allExpert, $expertProject,
			  function ($obj_a, $obj_b) {
			    return $obj_a["id_exp"] - $obj_b["id_exp"];
			  }
			);

			$info = [
				'expertList'=>$expertList,
				'projectExp'=>$expertProject
			];

			return redirect("newproject")->with("info",$info);
		}


		public static function createTuple($datas, int $nbTuple){
			$nbDatasToTuple = $datas->count();
			$startFor = 0;

			switch ($nbTuple) {
				case 2:
					foreach ($datas as $aData) {
						for($i=$startFor;$i<$nbDatasToTuple-1;$i++)
						{
							
							$s = new Pairwise();
							$s->id_exp = session()->get('idExp');
							$s->id_data1 = $aData->id_data;
							$s->id_data2 = $datas[$i+1]->id_data;
							$res[] = $s;

						}
						$startFor ++;
					}
					break;
				
				case 3:
					$startFor2 = 0;

					for($a=$startFor;$a<$nbDatasToTuple-2;$a++)
					{
						for($b=$a + 1;$b<$nbDatasToTuple;$b++)
						{
							for($c=$b + 1;$c<$nbDatasToTuple;$c++)
							{
								$s = new Tripletwise();
								$s->id_exp = session()->get('idExp');
								$s->id_data1 = $datas[$a]->id_data;
								$s->id_data2 = $datas[$b]->id_data;
								$s->id_data3 = $datas[$c]->id_data;
								$res[] = $s;
							}
						}
					}
					break;

					default:
						return false;
						break;
			}
			return $res;	
		}
}
