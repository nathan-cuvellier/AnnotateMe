<?php

namespace App\Http\Controllers\Project\CRUD;

use App\Expert;
use App\Http\Controllers\Controller;
use App\Participation;
use App\Http\Requests\Project\UpdateRequest;
use App\Project;
use App\SessionMode;

class UpdateController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $project = Project::find($id);
        $sessionModes = SessionMode::all();
        $experts = Expert::all();

        if($project->id_exp != session('expert')['id'] && session('expert')['type'] != 'superadmin')
            return abort(403);

        // return the list of id expert who participle to the project
        $idExpertsParticipation = array_map(function ($c) {
            return $c['id_exp'];
        }, Participation::query()
            ->select('id_exp')
            ->where('id_prj', $id)
            ->get()
            ->toArray());

        return view('project.CRUD.update', compact('id', 'project', 'experts', 'sessionModes', 'idExpertsParticipation'));
    }

    /**
     * @param $id
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UpdateRequest $request)
    {
        $project = Project::find($id);
        $data = $request->except('_token');

        $updateProject = [
            'name_prj' => $data['name_prj'],
            'desc_prj' => $data['desc_prj'],
            'id_mode' => $data['id_mode'],
            'limit_prj' => $data['limit_prj'],
            'waiting_time_prj' => (int) $data['waiting_time_prj'],
            'online_prj' => isset($data['online_prj']),
        ];

        $participation = Participation::query()
            ->where('id_prj', $id)
            ->delete();

        if (!isset($data['selectexperts']))
            $experts = Expert::all();
        else {
            $experts = Expert::query()
                ->whereIn('id_exp', array_keys($data['experts']))
                ->orWhere('type_exp', 'superadmin')
                ->orWhere('id_exp', session('expert')['id'])
                ->get();
        }

        foreach ($experts as $expert) {
            Participation::create(['id_prj' => $id, 'id_cptlvl' => 1, 'id_exp' => $expert->id_exp]);
        }
        
        $project->update($updateProject);


        

        return redirect()->route('project.read', ['id' => $id])->with('update', 'The project has been updated');
    }

}