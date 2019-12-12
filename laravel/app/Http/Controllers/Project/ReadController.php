<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\LimitAnnotation;
use App\Participation;
use App\Project;
use DateTime;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function show($id)
    {
        $participations = Participation::query()
            ->select('id_prj', 'id_exp')
            ->where('id_exp',session('expert')['id'])
            ->get();

        $data = Project::query()
            ->where('id_prj', $id )
            ->join('session_mode','session_mode.id_mode','=','project.id_mode')
            ->join('interface','interface.id_int','=','project.id_int')
            ->first();

        $access = false;

        $limitAnnotation = LimitAnnotation::query()
            ->where('id_exp', session('expert')['id'])
            ->where('id_prj', $id)
            ->first();

        $canAnnotate = true;
        if(!is_null($limitAnnotation) ) {
            $now = new DateTime();
            $dateLimit = new DateTime($limitAnnotation->date_limit_annotation);

            if($now < $dateLimit) {
                $canAnnotate = false;
            }
        }


        foreach ($participations as $participation) {
            if ($id == $participation->id_prj)
                $access = true;
        }

        if(!$access)
            return redirect()->route('project.list')->with('notAllowed','You do not have access to this project.');

        return view ('project.CRUD.read',['project' => $data, 'canAnnotate' => $canAnnotate]);

    }
}
