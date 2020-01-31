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

        if (!is_null($limitAnnotation)) {
            $now = new DateTime();
            $dateLimit = new DateTime($limitAnnotation->date_limit_annotation);

            if ($now < $dateLimit) {
                $date = date('\t\h\e d F \a\t H:i', strtotime($limitAnnotation->date_limit_annotation));

                return redirect()->route('project.list')->with('warning', 'You can annotate again ' . $date);
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
        
        Annotation::create(
            [
                "id_exp" => session('expert')['id'],
                "id_cat" => $request->category,
                "id_data" => $request->id_data,
                "date" => new DateTime(),
                "expert_sample_confidence_level" => $request->expert_sample_confidence_level
            ]
        );
        $project = Project::findOrFail($id);

        if (session('annotation')['id_mode'] == 2)
            session()->put('annotation.nb_annotation_remaining', session('annotation')['nb_annotation_remaining'] - 1);

        if ($project->id_int === 1) {
            return $this->setLimit($project);
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
            $dateLimit = ($limitAnnotation->date_limit_annotation)->format('\t\h\e d F \a\t H:i');

            return redirect()->route('project.list')->with('success', 'Thanks for annotation, You can annotate again this project ' . $dateLimit . ' (UTC +1)');
        } else {
            return redirect()->route('project.annotate', compact('id'));
        }
    }
}
