<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Participation;
use App\SessionMode;
use App\InterfaceMode;
use App\Expert;
use App\Project;
use App\Data;
use App\Category;
use App\Http\Requests\Project\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{

    public function create()
    {
        $sessionModes = SessionMode::all();
        $interfaceModes = InterfaceMode::all();
        $experts = Expert::all();
        return view('project.CRUD.create', [
            "sessionModes" => $sessionModes,
            "interfaceModes" => $interfaceModes,
            "experts" => $experts]);
    }

    public function check(CreateRequest $request)
    {

        $data = Request();
        $file = $data->file("datas");
        $id_exp = session('expert')['id'];

        $experts = [];

        //If there is selected Experts to annotate this project
        if ($data['selectexperts'] !== null) {
            //$experts = $data['experts'] ;
            //$experts[$id_exp] = 'on';

            $experts = Expert::query()
                ->whereIn('id_exp', array_keys($data['experts']))
                ->orWhere('type_exp', 'superadmin')
                ->orWhere('id_exp', $id_exp)
                ->get();

        } else {
            //Default attribution to all experts
            $experts = Expert::All();
        }
        //Create the project
        $prj = Project::create([
            'name_prj' => str_replace(' ', '_', $data['name_prj']),
            'desc_prj' => $data['desc_prj'],
            'id_mode' => $data['id_mode'],
            'id_int' => $data['id_int'],
            'id_exp' => $id_exp,
            'limit_prj' => $data['limit_prj'],
        ]);

        //Test if there is no problem with the zip file
        if ($zipfiletest = $this->zipfile($file, $prj) === true) {
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
            //If there is an error, delete the project
            $prj->delete();

            //Return errors with the return of $zipfiletest
            return back()->withInput()->with('ZipError', $zipfiletest);
        }
    }

    /**
     * Scan the zip to find errors
     *
     * @param $zip
     * @param $path
     * @param $prj
     * @return bool|string
     */
    public function zipfile($file, $prj)
    {
        $fileName = $file->getClientOriginalName();
        $path = __DIR__ . '/../../../../public/storage/app/datas/';

        //Check if the /datas directory already exist
        if (is_dir($path)) {
            //Count the number of files in the /data directory plus one for the file that will be added
            $datas = scandir($path);
            $nb = count($datas) + 1;
        } else {
            //Create the directory
            $nb = 0;
            mkdir($path, 0775, true);
            $datas = scandir($path);
        }

        //Test is the file is a .zip
        if (strstr($fileName, ".zip")) {
            //Store the .zip file in the /data directory
            $file->storeAs('datas/' . $prj->name_prj, $fileName);

            //Define the $zip var to store the .zip file and open it
            $zip = new \ZipArchive;

            //Get the project name to create a directory in /datas
            $nameprj = str_replace(' ', '_', $prj->name_prj);

            //Define the path to the file with the absolute path to /datas and add it the project name
            $pathtofile = $path . $nameprj;

            //Test if the .zip file can be open
            if ($zip->open($pathtofile . "/" . $fileName) === true) {
                //Use the scanzip function that return true if the .zip have no errors and the string error if there is one
                if ($scanzip = $this->scanzip($zip, $path, $prj) !== true) {

                    //return the string of error to the page
                    return $scanzip;
                }

                //Extract the .zip in the project folder
                $zip->extractTo($pathtofile);

                //Use the createdata function to insert the path to the images in the database
                $this->createdata($pathtofile . "/" . strstr($fileName, ".", true), $nameprj . "/" . strstr($fileName, ".", true), $prj);

                //Use the createcategories function to insert the categories from the categories.txt file into the database
                $this->createcategories($path, $nameprj . "/" . strstr($fileName, ".", true), $prj);

                //Close the zip
                $zip->close();
            } else {
                dd($zip->open($path . $nameprj . "/" . $fileName));
            }

            system("rm " . $path . $nameprj . "/" . $fileName);

            return true;
        }
        return false;
    }

    /**
     * Scan the zip to find errors
     *
     * @param $zip
     * @param $path
     * @param $prj
     * @return bool|string
     */

    public function scanzip($zip, $path, $prj)
    {
        //Accepted formats for the files into the .zip
        $accepted = ['jpg', 'jpeg', 'png', 'gif', 'txt'];
        $zipfiles = [];
        $foldername = "";
        
        //Test if the folder is not empty
        if ($zip->numFiles == 1) {

            if ($zip->statIndex(0)->numFiles >= 2) {
                //Get the folder name with the name of the file[0] (master file)
                $foldername = $zip->getNameIndex(0);
            } else {
                return 'The fine in the zip must have at least 2 files (categories.txt and an image)';
            }
        } else if ($zip->numFiles == 0) {
            return 'The zipFile cannot be empty';
        } else {
            return 'Only one folder is allowed in the zip, try to put the categories.txt and the images in the same folder and then compress it';
        }


        //If the folder name have space cancel the process and return error
        if ($foldername !== str_replace(' ', '', $foldername)) {
            return 'Space symbols in the zip folder is not allowed ( instead of ' . $foldername . ', try ' . str_replace(' ', '', $foldername);
        }

        //Get the individual file name by removing the path
        for ($i = 1; $i < $zip->numFiles; $i++) {
            $zipfiles[] = str_replace($foldername, '', $zip->getNameIndex($i));
        }

        //If the project is simple, check the categories.txt
        if ($prj->id_int === 1) {
            //Tests on the files in the .zip
            $categories = false;
            foreach ($zipfiles as $key => $value) {
                //Test if the categories.txt file is found in the .zip
                if (strtolower($value) === "categories.txt") {
                    $categories = true;
                }

                //Test if the file extention is allowed
                if (strstr($value, ".") !== false) {
                    $extention = strtolower(str_replace('.', '', substr($value, strrpos($value, '.'))));

                    if (in_array($extention, $accepted) === false) {
                        return 'The document ' . $value . ' have a wrong extention : ' . $extention . ' is not accepted, unlike .jgp .jpeg .png .gif .txt)';
                    }
                }
            }

            if ($categories === false) {
                return 'There is not categories.txt document';
            } else {

                $foldername = "";
                if ($zip->numFiles > 0) {
                    $foldername = $zip->getNameIndex(0);
                }

                if ($zip->getFromName($foldername . 'categories.txt') === false) {
                    return 'categories.txt cannot be opened, try again.';
                } else if ($zip->getFromName($foldername . 'categories.txt') === '') {
                    return 'categories.txt cannot be empty, add categories to it.';
                }

            }
        }
        return true;
    }

    /**
     * Create all the datas in the database from the images in the project folder
     * @param $path
     * @param $spath
     * @param $prj
     */
    public function createdata($path, $spath, $prj)
    {
        //Get the array of files
        $files = array_slice(scandir($path), 2);
        $images = ['jpg', 'jpeg', 'png', 'gif'];

        foreach ($files as $key => $value) {
            if (strstr($value, ".") !== false) {
                $extention = strtolower(str_replace('.', '', substr($value, strrpos($value, '.'))));

                if (in_array($extention, $images) !== false) {
                    $img = Data::create(['pathname_data' => $spath . "/" . $value, 'id_prj' => $prj->id_prj]);
                }
            }
        }
    }

    /**
     * Create all the categories in the database from the categories.txt file
     * @param $path
     * @param $spath
     * @param $prj
     */
    public function createcategories($path, $spath, $prj)
    {
        if ($prj->id_int == '1') {
            //Path to the categories file
            $catpath = $path . $spath . '/categories.txt';

            //Lines in the categories file
            $lines = file($catpath);

            //Insert  every line of the categories file in the database
            foreach ($lines as $line_num => $line) {
                Category::create([
                    'label_cat' => $line,
                    'id_prj' => $prj->id_prj,
                    'num_line' => $line_num,
                ]);
            }
        } else if ($prj->id_int == '2') {
            Category::create(['label_cat' => 'Yes', 'id_prj' => $prj->id_prj, 'num_line' => 1]);
            Category::create(['label_cat' => 'No', 'id_prj' => $prj->id_prj, 'num_line' => 2]);
            Category::create(['label_cat' => 'I don\'t know', 'id_prj' => $prj->id_prj, 'num_line' => 3]);
        } else if ($prj->id_int == '3') {
            Category::create(['label_cat' => 'Image 1', 'id_prj' => $prj->id_prj, 'num_line' => 1]);
            Category::create(['label_cat' => 'Image 2', 'id_prj' => $prj->id_prj, 'num_line' => 2]);
            Category::create(['label_cat' => 'I don\'t know', 'id_prj' => $prj->id_prj, 'num_line' => 3]);
        }
    }

    public function getDirContents($dir)
    {
        $results = array();
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            if (!is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $results[] = $value;
            } else if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $results[] = $value;
                getDirContents($dir . DIRECTORY_SEPARATOR . $value);
            }
        }

        return $results;
    }
}
