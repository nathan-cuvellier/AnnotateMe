<?php      

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Http\Requests\ValidateAnnot;

use App\Tripletwise;
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
use DateTime;
use DateInterval;
use DateTimeZone;


class InterfaceController extends Controller
{
	
    private $confiance;

    public static function getElement($prj)
    {   

        // $allData = Data::whereIn('id_prj', [$prj->id_prj])->orderBy('priority_data')->orderByDesc('nbannotation_data')->get()->all();
        $allData = Data::whereIn('id_prj', [$prj->id_prj])->orderByDesc('priority_data')->orderBy('nbannotation_data')->get()->all();

        return array_slice($allData, 0, 3);
    }


	/**
	 * Store the incoming blog post.
	 *
	 * @param  StoreBlogPost  $request
	 * @return Response
	 */
	public function store(ValidateAnnot $request)
	{
        $prj = Project::find($request->input('id'));

        /* LIMITATION BY NUMBER OF ANNOTATIONS */
        if (session()->has('nb_annot_limit')) {

            session()->decrement('nb_annot_limit');
            $limit = session()->get('nb_annot_limit');
            if (session()->get('nb_annot_limit') == 0) {
                session()->forget('nb_annot_limit');
                session()->put('message','You have completed your annotation session. Thank you!');
                return redirect("/projects");
            }
        }
        else{
            if($prj->id_mode == 2) //If project limited by number of annotations
            {
                session()->put('nb_annot_limit',$prj->limit_prj-1);
            }
        } 

        // CREATE A NEW DATE IN THE DATABASE
        $date = new Date();
        $date->date = new DateTime;
        if (Date::whereIn('date', [$date->date->format("Y-m-d")])->count() == 0) {
            $date->save();
        }
        

        switch ($prj->id_int) {
            // ============
            // CLASSIFICATION
            // ============
            case 1:
                $element = Data::find($request->input('elements')[0]);

                $element->priority_data = 0;
                $element->nbannotation_data += 1;
                $element->save();

                $annot = new Annotation();
                $annot->id_exp = session()->get("idExp");
                $annot->date = $date->date->format("Y-m-d");
                $annot->id_data = $element["id_data"];
                $annot->id_cat = $request->input('cat');
                $annot->expert_sample_confidence_level = $request->input('confiance');
                $annot->save();

                break;

            // ==========
            // PAIRWISE SIMILARITY
            // ==========
            case 2:
                $i=0;
                foreach ($request->input('elements') as $aElePath) {
                    $annotateDatas[$i] = Data::find($aElePath);
                    $annotateDatas[$i]->priority_data = 0;
                    $annotateDatas[$i]->nbannotation_data += 1;
                    $annotateDatas[$i]->save();
                    $i++;
                }

                $pairwise = new Pairwise();
                $pairwise->id_data1 = $request->input('elements')[0];
                $pairwise->id_data2 = $request->input('elements')[1];
                $pairwise->id_exp = session()->get("idExp");
                $pairwise->date = $date->date->format("Y-m-d");
                $pairwise->id_cat = $request->input('cat');
                $pairwise->save();
                
                break;

            // ==========
            // TRIPLETWISE SIMILARITY
            // ==========
            case 3:
                $i=0;
                foreach ($request->input('elements') as $aElePath) {
                    $annotateDatas[$i] = Data::find($aElePath);
                    $annotateDatas[$i]->priority_data = 0;
                    $annotateDatas[$i]->nbannotation_data += 1;
                    $annotateDatas[$i]->save();
                    $i++;
                }

                $tripletwise = new Tripletwise();
                $tripletwise->id_data1 = $request->input('elements')[0];
                $tripletwise->id_data2 = $request->input('elements')[1];
                $tripletwise->id_data3 = $request->input('elements')[2];
                $tripletwise->id_exp = session()->get("idExp");
                $tripletwise->date = $date->date->format("Y-m-d");
                $tripletwise->id_cat = $request->input('cat');
                $tripletwise->save();

                break;
            }

            session()->put('oldConfiance', $request->input('confiance'));

            return redirect("/projects/{$request->input('id')}/annotation");
	}
	

    public function view($id){

        $SNow = null;
        
        $projectInterface = Project::find($id);

        $time = $projectInterface->limit_prj*60 + 3600;
        if(session()->get('startAnnot') !== null)
        {

            if($projectInterface->id_mode == 1)
            {
                $now = new DateTime();
                //barbare
                $now->add(new DateInterval('PT' . $time . 'S'));
                $SNow = $now->format('M d, Y H:i:s');
            }else
            {
                $SNow = null;
            }

            
        }
        else
        {
            session()->put("startAnnot", true);
        }
        

        if (session()->get('typeExp') != NULL && session()->get('typeExp') == true)
        {

            $allElements = InterfaceController::getElement($projectInterface);


            switch ($projectInterface->id_int) {
                case 1:
                    $viewReturn = "classification";
                    $elements = array_slice($allElements, 0, 1);
                    break;

                case 2:
                    $viewReturn = "pairwise_similarity";
                    $elements = array_slice($allElements, 0, 2);
                    break;

                case 3:
                    $viewReturn = "tripletwise_similarity";
                    $elements = array_slice($allElements, 0, 3);
                    break;
            }

            if(session()->get("oldConfiance") === null)
                $oldConfiance = 1;
            else
                $oldConfiance = session()->get("oldConfiance");

            return view($viewReturn,
                [
                    'now'=>$SNow,
                    'prj'=>$projectInterface,
                    'allCat'=>Category::whereIn('id_prj', [$id])->get(),
                    'elements'=>$elements,
                    'oldConfiance'=> $oldConfiance ,
                ]

            );
    
        }
        else
            return view('error_not_connected');
    }
}