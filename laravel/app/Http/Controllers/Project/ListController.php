<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Participation;
use App\Project;
use App\InterfaceMode;
use App\SessionMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ListController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $expert = session()->get('expert');
        $query = Participation::query()->where('participation.id_exp', $expert['id']);

        $checkParticipeInAtLeastOneProject = $query;

        if(count($checkParticipeInAtLeastOneProject->get()) === 0) // return to the project.list
            return view('project.list', ['noProjectFound' => 'You don\'t participate in any project']);

        $query->join('project', 'project.id_prj', '=', 'participation.id_prj')
            ->join('interface', 'interface.id_int', '=', 'project.id_int');

        $search = false;
        if (isset($request->searchSend)) {
            if (isset($request->search))
                $query->where('name_prj', 'ILIKE', '%' . str_replace(' ', '_', $request->search) . '%');

            if (isset($request->interface) && $request->interface != "default")
                $query->where('interface.id_int', $request->interface);

            if (isset($request->sessionMode) && $request->sessionMode != "default")
                $query->where('id_mode', $request->sessionMode);

            $search = true;
        } else if (isset($request->reset))
            return redirect($request->getPathInfo()); // redirect without param GET

        $interfaces = InterfaceMode::all();
        $sessionsMode = SessionMode::all();
        $projectsList = $query->get();

        return view('project.list', compact('projectsList', 'interfaces', 'sessionsMode', 'search'));
    }

}
