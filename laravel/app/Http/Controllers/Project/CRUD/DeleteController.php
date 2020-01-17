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
use App\Project;
use App\SessionMode;
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

        Annotation::query()
            ->whereIn('id_cat', $categories)
            ->whereIn('id_data', $datas)
            ->delete();

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
        system('rm -rf ' . __DIR__ . '/../../../../public/storage/app/datas/' . str_replace(' ', '\ ', $project->name_prj));
        //dd(glob(__DIR__ . '/../../../../public/storage/app/datas/'.$project->name_prj.'/*'));
        //rmdir(__DIR__ . '/../../../../public/storage/app/datas/'. $project->name_prj);

        Project::find($id)
            ->delete();

        return redirect()->route('project.list')->with('success', 'Project deleted with success !');
    }
}
