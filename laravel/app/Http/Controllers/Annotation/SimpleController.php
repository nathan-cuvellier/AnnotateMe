<?php

namespace App\Http\Controllers\Annotation;

use App\Http\Controllers\Controller;
use App\Participation;
use App\SessionMode;
use App\InterfaceMode;
use App\Expert;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SimpleController extends Controller
{

    public function showSimple()
    {
    	return view('project.annotation.simple');
    }
    public function showDouble()
    {
    	return view('project.annotation.double');
    }
    public function showTriple()
    {
    	return view('project.annotation.triple');
    }
}
