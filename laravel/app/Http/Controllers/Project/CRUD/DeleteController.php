<?php

namespace App\Http\Controllers\Project\CRUD;

use App\Category;
use App\Data;
use App\Expert;
use App\Http\Controllers\Controller;
use App\InterfaceMode;
use App\LimitAnnotation;
use App\Participation;
use App\Annotation;
use App\Pairwise;
use App\Project;
use App\SessionMode;
use App\Triplewise;
use Illuminate\Http\Request;

class DeleteController extends Controller
{

    /**
     * DeleteController constructor.
     */
    public function __construct()
    {
        $this->middleware('HighGrade'); // just admin or superadmin
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $project = Project::findOrFail($id);

        // Delete only if superadmin or if he is the owner of the project
        if(session('expert')['id'] != $project->id_exp && session('expert')['type'] != "superadmin")
            return abort(403);

        $categories = Category::query()
            ->select('id_cat')
            ->where('id_prj', $id)
            ->get()
            ->toArray();
            
        $datas = Data::query()
            ->select('id_data')
            ->where('id_prj', $id)
            ->get()
            ->toArray();

        $int = Project::query()
            ->where('id_prj', $id)
            ->first();

   

        if ($int->id_int == 1) {

            Annotation::query()
                ->whereIn('id_cat', $categories)
                ->whereIn('id_data', $datas)
                ->delete();

        } elseif ($project->id_int == 2) {

            Pairwise::query()
                ->whereIn('id_cat', $categories)
                ->whereIn('id_data1', $datas)
                ->whereIn('id_data2', $datas)
                ->delete();
        }
        elseif ($project->id_int==3) {
            Triplewise::query()
                ->whereIn('id_data1', $datas)
                ->whereIn('id_data2', $datas)
                ->whereIn('id_data3', $datas)
                ->delete();
        }



        Data::query()
            ->where('id_prj', $id)
            ->delete();

        Category::query()
            ->where('id_prj', $id)
            ->delete();

        Participation::query()
            ->where('id_prj', $id)
            ->delete();

        LimitAnnotation::query()
            ->with('id_prj', $id)
            ->delete();


        $project = Project::findOrFail($id);
        system('rm -rf ' . __DIR__ . '/../../../../../public/storage/app/datas/' . $project->name_prj);

        $project->delete();

        return redirect()->route('project.list')->with('success', 'Project deleted with success !');
    }
}
