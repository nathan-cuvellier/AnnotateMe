<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\AnnotationRequest;
use App\LimitAnnotation;
use Illuminate\Http\Request;
use DateTime;
use App\Project;
use App\Data;
use App\Category;
use App\Participation;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use App\Annotation;
use App\Pairwise;
use App\Triplewise;
use Illuminate\Support\Facades\Redirect;

class AnnotationController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $limitAnnotation = LimitAnnotation::query()
            ->where('id_exp', session('expert')['id'])
            ->where('id_prj', $id)
            ->first();

        $data = Project::query()
            ->join('data', 'project.id_prj', '=', 'data.id_prj')
            ->join('session_mode', 'session_mode.id_mode', '=', 'project.id_mode')
            ->join('category', 'category.id_prj', '=', 'project.id_prj')
            ->join('interface', 'interface.id_int', '=', 'project.id_int')
            ->where('project.id_prj', $id)
            ->first();

        // If there is a problem during the creation of project, the data (pictures) or categories, may not be created, so $data is null 
        if (is_null($data))
            return redirect()->route('project.list')->with('error', 'Error project not found');

        /**
         * Redirect the user with a message if it is in the "limit_annotation" table and the current date is lower than the date entered in the table
         * if the user is in the table but the current date is greater than the date entered in the table, the row concerned is deleted
         */
        if (!is_null($limitAnnotation)) {
            $now = new DateTime();
            $dateLimit = new DateTime($limitAnnotation->date_limit_annotation);

            if ($now < $dateLimit) {
                $date = date('d F \a\t H:i', strtotime($limitAnnotation->date_limit_annotation));

                return redirect()->route('project.list')->with('warning', 'You can annotate again the ' . $date);
            } else {
                $limitAnnotation->delete();
            }
        }

        if (!$data->online_prj)
            return redirect()->route('project.list')->with('warning', 'the project "' . $data->name_prj . '" is offline');

        // Get particpation, in order to check if the expert is allow to access at this page
        $participation = Participation::query()
            ->where('id_prj', $id)
            ->where('id_exp', session('expert')['id'])
            ->first();

        if (is_null($participation))
            return abort(403);

        $pictures = Data::query()->where('data.id_prj', $id)->get();
        $number_pictures = count($pictures);

        if (!session()->has('annotation')) {
            $annotation = [
                'id_prj' => $data->id_prj,
                'id_mode' => $data->id_mode,
            ];

            if ($data->id_mode == 1)
                $annotation['time_end_annotation'] = (new DateTime())->modify("+{$data->limit_prj} minutes")->format('Y-m-d H:i:s');
            else if ($data->id_mode == 2)
                $annotation['nb_annotation_remaining'] = $data->limit_prj;

            session()->put('annotation', $annotation);
        } else {
            /*
             * New Session if expert change project
             */
            if (session('annotation')['id_prj'] != $data->id_prj) {
                $annotation = [
                    'id_prj' => $data->id_prj,
                    'id_mode' => $data->id_mode,
                ];

                if ($data->id_mode == 1)
                    $annotation['time_end_annotation'] = (new DateTime())->modify("+{$data->limit_prj} minutes")->format('Y-m-d H:i:s');
                else if ($data->id_mode == 2)
                    $annotation['nb_annotation_remaining'] = $data->limit_prj;

                session()->put('annotation', $annotation);
            }
        }


        if ($data->id_int === 1)
        {
            $categorys = Category::query()->where('category.id_prj', $id)->get();
            $number = $this->max_img($pictures, 1);
            $view = 'project.annotation.simple';
        }
        else if ($data->id_int === 2)
        {
            $categorys = Category::query()->where('category.id_prj', $id)->get();
            $number = $this->max_img($pictures, 2);
            $view = 'project.annotation.double';
        }
        else
        {
            $categorys = [];

            $number = $this->max_img($pictures, 3);


            foreach ($number as $value)
            {

                
                $image_id = $pictures[$value]->id_data;


                //var_dump($image_id);
                $categorys[] = Category::query()->where(
                    ['category.id_prj' => $id, 'category.label_cat' => $image_id])->first();

            }
            $view = 'project.annotation.triple';
        }
        session()->put('category',$categorys);

        return view($view, [
            "data" => $data,
            "pictures" => $pictures,
            "number" => $number,
            "number_pictures" => $number_pictures,
            "categorys" => $categorys,
        ]);
    }

    /**
     * @param AnnotationRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function annotate(AnnotationRequest $request, $id)
    {
        $idValideConfidenceLevel = (int) $request->expert_sample_confidence_level;

        if($idValideConfidenceLevel < 150)
            $idValideConfidenceLevel = 1;
        else if($idValideConfidenceLevel >= 150 && $idValideConfidenceLevel < 300)
            $idValideConfidenceLevel = 2;
        else if($idValideConfidenceLevel >= 300)
            $idValideConfidenceLevel = 3;
        
       
        $data = Project::query()
            ->find($id);

            



        if($data->id_int == 1){
            Annotation::create(
                [
                    "id_exp" => session('expert')['id'],
                    "id_cat" => $request->category,
                    "id_data" => $request->id_data,
                    "date" => new DateTime(),
                    "expert_sample_confidence_level" => $idValideConfidenceLevel
                ]
            );
    
        } else if ($data->id_int == 2){
            Pairwise::create(
                [
                    "id_exp" => session('expert')['id'],
                    "id_cat" => $request->category,
                    "id_data1" => $request->id_data1,
                    "id_data2" => $request->id_data2,
                    "date" => new DateTime(),
                    "expert_sample_confidence_level" => $idValideConfidenceLevel
                ]
            );
    
        }else if ($data->id_int == 3){
            
            $cat = Category::query()
            ->find($request->category);

            $category_select = session('category')[1]->label_cat;

            if ($cat->label_cat == $category_select){
                $third_cat = session('category')[2]->label_cat;
            } else {
                $third_cat = session('category')[1]->label_cat;
            }


            Triplewise::create(
                [
                    "id_exp" => session('expert')['id'],
                    "id_data1" => $request->id_data,
                    "id_data2" => $cat->label_cat,
                    "id_data3" => $third_cat,
                    "date" => new DateTime(),
                    "expert_sample_confidence_level" => $idValideConfidenceLevel
                ]
            );
    
        }
        


        $total_nb_annotation = Data::query()->where('id_prj', $id)->sum('nbannotation_data');

        $image = Data::find($request->id_data);

        if($image) {
            $image->nbannotation_data = $image->nbannotation_data + 1;
            //$image->priority_data = ($image->nbannotation_data/ ($total_nb_annotation + 1));
            $image->save();
        }

        $this->set_priority($id);

        $project = Project::findOrFail($id);

        if (session('annotation')['id_mode'] == 2)
            session()->put('annotation.nb_annotation_remaining', session('annotation')['nb_annotation_remaining'] - 1);

        return $this->setLimit($project);
    }

    /**
     * setLimit
     *
     * @param  mixed $project
     *
     * @return void
     */
    public function setLimit(Project $project)
    {
        $id = $project->id_prj;
        // When expert has reached the limit
        if ((session()->has('annotation.nb_annotation_remaining') && session('annotation')['nb_annotation_remaining'] <= 0)
            || (session()->has('annotation.time_end_annotation') && (new DateTime() >= new DateTime(session()->get('annotation.time_end_annotation'))))
        ) {
            session()->forget('annotation'); // unset session annotation

            $limitAnnotation = LimitAnnotation::query()
                ->where('id_prj', $id)
                ->where('id_exp', session('expert')['id'])
                ->first();

            if (is_null($limitAnnotation)) {
                $limitAnnotation = LimitAnnotation::create([
                    'id_exp' => session('expert')['id'],
                    'id_prj' => $id,
                    'date_limit_annotation' => (new DateTime())->modify("+{$project->waiting_time_prj} hours")
                ]);
            } else {
                $limitAnnotation->update(['date_limit_annotation' => (new DateTime())->modify("+{$project->waiting_time_prj} hours")]);
            }
            $dateLimit = ($limitAnnotation->date_limit_annotation)->format('d F \a\t H:i');

            return redirect()->route('project.list')->with('success', 'Thanks for annotation, You can annotate again this project the ' . $dateLimit . ' (UTC +1)');
        } else {
            return redirect()->route('project.annotate', compact('id'));
        }
    }

    public function max_prop($array, $prop) {
        $min = 0;
        $id_min = 0;

        foreach($array as $key => $value)
        {
            $temp = $value->$prop;
            if ($temp >= $min)
            {
                $id_min = $key;
                $min = $temp;
            }
        }
        return $id_min;
    }

    public function max_img($images, $nb = 1)
    {
        $min = [];
        $id_min = [];

        for ($i=0; $i < $nb; $i++)
        {
            $min[] = 0;
            $id_min[] = 0;
        }

        foreach ($images as $k => $v)
        {
            $prio = $v->priority_data;
            $min_prio_id = array_search(min($min), $min);

            if ($prio > $min[$min_prio_id])
            {
                $min[$min_prio_id] = $prio;
                $id_min[$min_prio_id] = $k;
            }
        }

        return $id_min;
    }

    public function set_priority($id) {

        $images = Data::query()->where('id_prj', $id)->get();
        $total = $images->sum('nbannotation_data');

        foreach ($images as $image)
        {
            $nb_annot = $image->nbannotation_data;

            $priority = 1 - ($nb_annot / ($total + 1));
            $alea = 1 + (rand(-10, 10)/100);

            $image->priority_data = $priority * $alea;

            $image->save();
        }
        
    }
}
