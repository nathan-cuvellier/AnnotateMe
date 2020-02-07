<?php

namespace App\Http\Controllers\Project\CRUD;

use App\Http\Controllers\Controller;
use App\Participation;
use App\SessionMode;
use App\InterfaceMode;
use App\Expert;
use App\Project;
use App\Data;
use App\Category;
use App\Http\Requests\Project\CreateRequest;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{

    public function __construct()
    {
        $this->middleware('HighGrade'); // just admin or superadmin
    }

    /**
     * Return the project creation view with the datas needed
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $sessionModes = SessionMode::all();
        $interfaceModes = InterfaceMode::all();
        $experts = Expert::query()
            ->where('type_exp', '<>', 'superadmin') // not select the superadmins, in order to put it by default in the project
            ->where('id_exp', '<>', session('expert')['id']) // not select the owner, in order to put it by default in the project
            ->whereNotNull('mail_exp') // if user is delete
            ->get();

        return view('project.CRUD.create', [
            "sessionModes" => $sessionModes,
            "interfaceModes" => $interfaceModes,
            "experts" => $experts]);
    }

    /**
     * Check all the datas of the project
     * If it pass all the test, the project/datas/categories/participations are created in the database
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function check(CreateRequest $request)
    {
        $data = Request();
        $file = $data->file("datas");
        $id_exp = session('expert')['id'];

        $experts = [];

        //If there is selected Experts to annotate this project
        if ($data['selectexperts'] !== null) {
            $experts = Expert::query()
                ->whereIn('id_exp', array_keys($data['experts']))
                ->orWhere('type_exp', 'superadmin')
                ->orWhere('id_exp', session('expert')['id'])
                ->whereNotNull('mail_exp')
                ->get();
        } else {
            //Default attribution to all experts
            $experts = Expert::query()->whereNotNull('mail_exp')->get();
        }

        //Create the project
        $prj = Project::create([
            'name_prj' => str_replace(' ', '_', $data['name_prj']),
            'desc_prj' => $data['desc_prj'],
            'id_mode' => $data['id_mode'],
            'id_int' => $data['id_int'],
            'id_exp' => $id_exp,
            'limit_prj' => $data['limit_prj'],
            'waiting_time_prj' => $data['waiting_time_prj'],
            'online_prj' => isset($data['online_prj']),
        ]);

        //Test if there is no problem with the zip file
        $zipfiletest = $this->zipfile($file, $prj);

        //If there is ,no problem
        if ($zipfiletest === true) {
            //Add experts participation
            foreach ($experts as $expert) {
                $participation = Participation::create([
                    'id_cptlvl' => '1',
                    'id_exp' => $expert->id_exp,
                    'id_prj' => $prj->id_prj,
                ]);
            }
            return redirect(route('project.list'));
        } else {

            //dd($prj);
            //If there is an error, delete the project
            $this->CancelProject($prj->id);


            //Return errors with the return of $zipfiletest
            return back()->withInput()->with('ZipError', $zipfiletest);
        }
    }

    /**
     * Check if there is a problem with the zip file
     *
     * @param $file
     * @param $prj
     * @return bool
     */
    public function zipfile($file, $prj)
    {
        //Get the file name
        $fileName = $file->getClientOriginalName();
        //Path to the server storage repertory
        $path = __DIR__ . '/../../../../../public/storage/app/datas/';

        //Check if the /datas directory already exist
        if (is_dir($path)) {

            //Count the number of files in the storage directory (/datas)
            $datas = scandir($path);

            //Add one for the file that will be added
            $nb = count($datas) + 1;
        } else {
            //Create the directory
            mkdir($path, 0775, true);

            //Count the number of files in the storage directory (/datas)
            $datas = scandir($path);
            $nb = 0;
        }

        //Test is the file is a .zip
        if (strstr($fileName, ".zip")) {

            //Get the project name to create a directory in /datas
            $projectname = str_replace(' ', '_', $prj->name_prj);

            //Define the path to the file with the absolute path to /datas and add it the project name
            $pathtoproject = $path . $projectname;

            //If the path to the project don't exist
            if (!is_dir($pathtoproject)) {
                //Create the directory for the project datas storage
                mkdir($pathtoproject, 0755, true);
            }

            //Define the path to the .zip file (in the project storage)
            $pathtozip = $pathtoproject . "/" . $fileName;

            //Test if it is possible to write in the project storage directory
            if (!is_writable($pathtoproject) || (move_uploaded_file($file, $pathtozip) != true)) {
                //If not, delete it and return an error
                if (is_dir($pathtoproject)) {
                    system("rm -R" . $pathtoproject);
                }
                
                return "Error, Can't store the .zip file";
            }


            //Define the $zip var to store the .zip file and open it
            $zip = new \ZipArchive;

            //Test if the .zip file can be opened
            if ($zip->open($pathtozip) != true) {

                //If not, delete the .zip file and return an error
                system("rm -R" . $pathtozip);
                return "Error, Can't open the .zip";
            }

            //Extract the .zip in the project folder
            $zip->extractTo($pathtoproject);

            //Close the zip
            $zip->close();

            //Delete the .zip file
            system("rm " . $pathtozip);

            //Use the prepareFile function
            //It return true if the project file have no errors 
            //Else, it return the error message
            $prepareFile = $this->prepareFile($pathtoproject);

            //If the function find an error
            if ($prepareFile != true) {

                //Delete the project storage directory
                system("rm " . $pathtoproject);

                //return the error message to the page
                return $prepareFile;
            }

            //Use the createdata function to insert the path to the images in the database
            $createdataserror = $this->createdata($pathtoproject, $prj);

            //If there is a problem while creating the datas in the database
            if ($createdataserror != true) {
                //Delete the project storage directory
                system("rm " . $pathtoproject);

                //return the error message to the page
                return $createdataserror;
            }

            //Use the createcategories function to insert the categories from the categories.txt file into the database
            $createcategorieserror = $this->createcategories($pathtoproject, $prj);
            
            //If there is a problem while creating the categories in the database
            if ($createcategorieserror !== true) {
                //Delete the project storage directory
                system("rm " . $pathtoproject);

                //return the error message to the page
                return $createcategorieserror;
            }

            //If there is no problem, return true
            return true;
        }

        //If the file is not a .zip, return the error message to the page
        return "Only .zip files are accepted";
    }

    //Prepare the datas in the project folder and check if there is no problem during the process
    public function prepareFile($pathtoproject)
    {
        //Use the getDirContent to extract images in /images and the categories.txt to the root
        $files = $this->getDirContents($pathtoproject);

        //Array of extentions that are allowed for images
        $imageext = ['.jpg', '.jpeg', '.png', '.gif'];

        //Path to the images folder
        $pathtoimages = $pathtoproject . "/images";

        //Test if the directory of the project don't exist
        if (!is_dir($pathtoproject)) {
            //Return an error and stop the process
            return "Error, the directory for the project .zip don't exist";
        }

        //Test if the images directory of the project don't exist
        if (!is_dir($pathtoimages)) {
            //Create the images directory 
            mkdir($pathtoimages, 0755, true);
        }

        //For all the files 
        foreach ($files as $key => $value) {
            //Get the base not of the folder
            $filename = basename($value);

            //Test if this is the category.txt file
            if ($filename == 'categories.txt') {
                //Move the file to the project directory
                rename($value, $pathtoproject . "/" . $filename);
            }

            //Get the extention position from the file name
            $dotposition = strrpos($filename, '.');

            if ($dotposition == false) {
                $dotposition = 0;
            }

            // extract the file extention from it's name
            $ext = strtolower(substr($filename, $dotposition));

            //Test if the file a an image with an allowed extention
            if (in_array($ext, $imageext)) {
                //Move the file to the directory of images
                rename($value, $pathtoimages . "/" . $filename);
                //rename($value, $pathtoimages . "/" . $this->randomString(32) . $ext);
            }
        }

        if (!file_exists($pathtoproject . "/categories.txt")) {
            return "Error, no categories.txt file in the .zip";
        }

        $imagesFiles = scandir($pathtoproject . "/images");
        $imagesFilesCount = 0;
        foreach ($imagesFiles as $key => $value) {
            if (in_array($value, ['..', '.']) !== true) {
                $imagesFilesCount = $imagesFilesCount + 1;
            }
        }

        if ($imagesFilesCount == 0) {
            return "Error, no images file in the .zip";
        }

        //Delete the files in the directory exept the categories.txt file and the images folder
        $files = scandir($pathtoproject);
        $exept = ['.', '..', 'images', 'categories.txt'];
        foreach ($files as $key => $value) {
            if (!in_array($value, $exept)) {
                system("rm -R" . $pathtoproject . '/' . $value);
            }
        }
        return true;
    }

    //Scan the project directory and try to extract all the datas recursively 
    //The images go to the /images directory
    //The categories.txt file go to the project root
    function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }
        return $results;
    }

    /**
     * Create all the datas in the database from the images in the project folder
     * @param $pathtoproject
     * @param $prj
     * @return bool|string
     */
    public function createdata($pathtoproject, $prj)
    {

        $extentions = ['jpg', 'jpeg', 'png', 'gif'];
        $pathimages = $pathtoproject . "/images";

        $projectname = str_replace(' ', '_', $prj->name_prj);
        $pathrelative = $projectname . "/images/";


        //Get the array of files
        $files = array_slice(scandir($pathimages), 2);
        $count = 0;

        foreach ($files as $key => $value) {

            if (strstr($value, ".") != false) {

                $extention = strtolower(str_replace('.', '', substr($value, strrpos($value, '.'))));

                if (in_array($extention, $extentions) != false) {
                    $count = $count + 1;
                }

            }
        }

        if ($count === 0) {
            return "Error, there is no images that can be used in this .zip";
        }

        foreach ($files as $key => $value) {

            if (strstr($value, ".") != false) {

                $extention = strtolower(str_replace('.', '', substr($value, strrpos($value, '.'))));

                if (in_array($extention, $extentions) != false) {
                    Data::create(['pathname_data' => $pathrelative . $value, 
                                'id_prj' => $prj->id_prj, 
                                'priority_data' => 1,
                                'nbannotation_data' => 0]);
                }

            }
        }
        return true;
    }

    /**
     * Create all the categories in the database from the categories.txt file
     * @param $pathtoproject
     * @param $prj
     * @return bool|string
     */
    public function createcategories($pathtoproject, $prj)
    {
        $projecttype = $prj->id_int;

        //Path to the config file
        $pathconfig = $pathtoproject . "/categories.txt";

        //Lines in the categories file
        if (!file_exists($pathconfig)) {
            return "Error categories.txt don't exist";
        }

        $lines = file($pathconfig);

        if ($lines == false) {
            return "Error, categories.txt cannot be empty";
        }

        $nbLineCount = 0;
        foreach ($lines as $line_num => $line) {
            $cleanLine = preg_replace('/[^A-Za-z0-9 ]/', '', $line);
            if ($cleanLine != " ")
            {
                $nbLineCount++;
            }
        }

        //dd($nbLineCount);
        if ($nbLineCount <=1 )
        {
            return "Error, categories.txt must have at least 2 lines";
        }

        if ($projecttype == '1') {
            //Insert  every line of the categories file in the database
            foreach ($lines as $line_num => $line) {

                $cleanLine = preg_replace('/[^A-Za-z0-9 ]/', '', $line);
                Category::create([
                    'label_cat' => $cleanLine,
                    'id_prj' => $prj->id_prj,
                    'num_line' => $line_num,
                ]);
            }
        } else if ($projecttype == '2') {
            Category::create(['label_cat' => 'Yes', 'id_prj' => $prj->id_prj, 'num_line' => 1]);
            Category::create(['label_cat' => 'No', 'id_prj' => $prj->id_prj, 'num_line' => 2]);
            Category::create(['label_cat' => 'I don\'t know', 'id_prj' => $prj->id_prj, 'num_line' => 3]);
        } else {
            Category::create(['label_cat' => 'Image 1', 'id_prj' => $prj->id_prj, 'num_line' => 1]);
            Category::create(['label_cat' => 'Image 2', 'id_prj' => $prj->id_prj, 'num_line' => 2]);
            Category::create(['label_cat' => 'I don\'t know', 'id_prj' => $prj->id_prj, 'num_line' => 3]);
        }

        return true;
    }

    public function randomString($length){
        $alphanumeric = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle(str_repeat($alphanumeric, $length)), 0, $length);
    }

    public function CancelProject($id)
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

        Project::find($id)
            ->delete();
    }
}