<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Annotation;
use App\Category;
use App\Competencelevel;
use App\Data;
use App\Date;
use App\Expert;
use App\Interfaces;
use App\Participation;
use App\Project;
use App\SessionMode;
use App\Pairwise;
use App\Tripletwise;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
