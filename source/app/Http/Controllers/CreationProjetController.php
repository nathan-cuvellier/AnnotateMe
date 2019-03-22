
<?php      

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateAnnot;

use App\SessionMode;
use App\Interfaces;

class CreationProjetController extends Controller
{
	public function view(){
		$listeModes = SessionMode::all();
		$listeInterfaces = Interfaces::all();
		if (session()->get('typeExp') != NULL && (session()->get('typeExp') == 'superadmin' || session()->get('typeExp') == 'admin'))
        {
			return view('createProject',["listeModes"=>$listeModes, "listeInterfaces"=>$listeInterfaces]);
		}
        else
            return view('error_not_allowed');
	}
}