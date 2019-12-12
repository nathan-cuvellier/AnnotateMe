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
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use App\Annotation;

class AnnotationController extends Controller
{
    public function show($id)
    {
        $limitAnnotation = LimitAnnotation::query()
            ->where('id_exp', session('expert')['id'])
            ->where('id_prj', $id)
            ->first();


        if(!is_null($limitAnnotation)) {
            $now = new DateTime();
            $dateLimit = new DateTime($limitAnnotation->date_limit_annotation);

            if($now < $dateLimit) {
                $date = date('\t\h\e d F \a\t H:i', strtotime($limitAnnotation->date_limit_annotation));

                return redirect()->route('project.list')->with('warning', 'You can annotate again ' . $date);
            } else {
                $limitAnnotation->delete();
            }

        }
        $now = new DateTime();

        $data = Project::query()
            ->join('data', 'project.id_prj', '=', 'data.id_prj')
            ->join('session_mode', 'session_mode.id_mode', '=', 'project.id_mode')
            ->join('category', 'category.id_prj', '=', 'project.id_prj')
            ->join('interface', 'interface.id_int', '=', 'project.id_int')
            ->where('project.id_prj', $id)
            ->first();

        $pictures = Data::query()
            ->where('data.id_prj', $id)->get();

        $categorys = Category::query()
            ->where('category.id_prj', $id)->get();

        //$annotation = ['id_prj' => $data['id_prj'], 'mode' => $data['id_mode'], 'valeur_annotation' => $data['limit_prj'], 'nb_annotation' => 0];

        if ($data->id_int === 1)
            $view = 'project.annotation.general';
        else if ($data->id_int === 2)
            $view = 'project.annotation.double';
        else
            $view = 'project.annotation.triple';

        $number_pictures = count($pictures);
        $number = rand(0, $number_pictures - 1);

        if (!session()->has('annotation')) {
            $annotation = [
                'id_prj' => $data->id_prj,
                'id_mode' => $data->id_mode,
            ];

            if ($data->id_mode == 1)
                $annotation['time_end_annotation'] = $data->limit_prj;
            else if($data->id_mode == 2)
                $annotation['nb_annotation_remaining'] = $data->limit_prj;

            session()->put('annotation', $annotation);
        } else {
            /*
             * New Session if expert change project
             */
            if(session('annotation')['id_prj'] != $data->id_prj) {
                $annotation = [
                    'id_prj' => $data->id_prj,
                    'id_mode' => $data->id_mode,
                ];

                if ($data->id_mode == 1)
                    $annotation['time_end_annotation'] = $data->limit_prj;
                else if($data->id_mode == 2)
                    $annotation['nb_annotation_remaining'] = $data->limit_prj;
            }
        }

        return view($view, [
            "now" => $now,
            "data" => $data,
            "pictures" => $pictures,
            "number" => $number,
            "number_pictures" => $number_pictures,
            "categorys" => $categorys,
        ]);


    }

    public function annotate(AnnotationRequest $request,  $id)
    {
       
        Annotation::create(
            [
                "id_exp"=> session('expert')['id'],
                "id_cat" => $request->category,
                "id_data" =>$request->id_data,
                "date" => new DateTime(),
                "expert_sample_confidence_level" => $request->expert_sample_confidence_level
            ]
        );
        $project = Project::findOrFail($id);

        if(session('annotation')['id_mode'] == 2)
            session()->put('annotation.nb_annotation_remaining', session('annotation')['nb_annotation_remaining'] - 1);

        if ($project->id_int === 1) {

            /**
             * When expert has reached the limit
             */
            if (session()->has('annotation.nb_annotation_remaining') && session('annotation')['nb_annotation_remaining'] <= 0
                ) {

                session()->forget('annotation'); // unset session annotation

                $limitAnnotation = LimitAnnotation::query()
                    ->where('id_prj', $id)
                    ->where('id_exp', session('expert')['id'])
                    ->first();

                $project = Project::find($id);

                if (is_null($limitAnnotation)) {
                    $limitAnnotation = LimitAnnotation::create([
                        'id_exp' => session('expert')['id'],
                        'id_prj' => $id,
                        'date_limit_annotation' => (new DateTime())->modify("+{$project->waiting_time_prj} hours")
                    ]);
                } else {
                    $limitAnnotation->update(['date_limit_annotation' => (new DateTime())->modify("+{$project->waiting_time_prj} hours")]);
                }
                $dateLimit = ($limitAnnotation->date_limit_annotation)->format('\t\h\e d F \a\t H:i');

                return redirect()->route('project.list')->with('success', 'Thanks for annotation, You can annotate again this project ' . $dateLimit);
            } else {
                return redirect()->route('project.annotate', compact('id'));
                //return view('project.annotation.general', ["now" => session('now'), "data" => session('data'), "pictures" => session('pictures'), "number" => $number, "number_pictures" => $number_pictures, "categorys" => session('categorys')]);
            }
        }
        /*
        else if (session('data')["id_int"] === 2) {
            session()->put('annotation', $annotation);
            return view('project.annotation.double', ["now" => $now, "data" => $data, "pictures" => $pictures]);
        } else {
            session()->put('annotation', $annotation);
            return view('project.annotation.triple', ["now" => $now, "data" => $data, "pictures" => $pictures]);
        }*/
        
        
        /*$date = \App\Date::create([
            "date" => new DateTime(),
        ]);*/
        

        
    }
}
