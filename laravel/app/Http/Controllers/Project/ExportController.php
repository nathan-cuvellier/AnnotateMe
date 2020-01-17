<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Triplewise;
use App\Annotation;
use App\Category;
use App\Data;
use App\Expert;
use App\Project;
use App\Pairwise;
use App\Participation;

use App\Http\Requests\Project\ExportRequest;


class ExportController extends Controller
{
    function indexExport($id)
    {
        
        $project = Project::query()
        ->where('id_prj', $id)
        ->first();


        if( is_null($project) || (session('expert')['id'] != $project->id_exp && session('expert')['id'] != 1) )
            return redirect()->route('project.list')->with('error','You do not have access to this project.');

        return view ('project.export',['project' => $project]);

    }









}
