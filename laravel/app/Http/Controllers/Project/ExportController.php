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

    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        $this->middleware('HighGrade'); // just accessible for admin or superadmin
    }

    function indexExport($id)
    {
        $project = Project::query()
            ->where('id_prj', $id)
            ->first();

        if (is_null($project))
            return abort(404);

        if (session('expert')['id'] != $project->id_exp && session('expert')['type'] != "superadmin")
            return abort(403); //redirect()->route('project.list')->with('error','You do not have access to this project.');

        if ($project->id_int == 1) {
            $dataSimple = Annotation::query()
                ->select("id_exp", "id_cat", "data.id_data", "expert_sample_confidence_level", "data.id_prj")
                ->join('data', 'annotation.id_data', '=', 'data.id_data')
                ->where('id_prj', $id)
                ->get();

            $dataSimple = json_encode($dataSimple);
            return $this->jsonToCsv($dataSimple, "/tmp/data" . date("Ymd-His") . ".csv", true);
        } elseif ($project->id_int == 2) {
            $dataDouble = Pairwise::query()
                ->select("id_data1", "id_data2", "id_exp", "id_cat", "data.id_prj"/*, "expert_sample_confidence_level"*/)
                ->join('data', 'pairwise.id_data1', '=', 'data.id_data')
                ->where('id_prj', $id)
                ->get();

            $dataDouble = json_encode($dataDouble);
            return $this->jsonToCsv($dataDouble, "/tmp/data" . date("Ymd-His") . ".csv", true);
        }
        elseif ($project->id_int==3) {
                $dataTriple = Triplewise::query()
          ->select("id_data1","id_data2","id_data3","id_exp","data.id_prj","expert_sample_confidence_level")
          ->join('data', 'triplewise.id_data1', '=', 'data.id_data')
           ->where('id_prj', $id)
           ->get();
        
           $dataTriple = json_encode($dataTriple);
           return $this->jsonToCsv($dataTriple, "/tmp/data".date("Ymd-His").".csv",true);
        }
    }

    function jsonToCsv($json, $csvFilePath = false, $boolOutputFile = false)
    {

        // See if the string contains something
        if ($json == "[]") {
            return redirect()->route('project.list')->with('error', 'No data found');
        }

        // If passed a string, turn it into an array
        if (is_array($json) === false) {
            $json = json_decode($json, true);
        }

        // If a path is included, open that file for handling. Otherwise, use a temp file (for echoing CSV string)
        if ($csvFilePath !== false) {
            $f = fopen($csvFilePath, 'w+');
            if ($f === false) {
                die("Couldn't create the file to store the CSV, or the path is invalid. Make sure you're including the full path, INCLUDING the name of the output file (e.g. '../save/path/csvOutput.csv')");
            }
        } else {
            $boolEchoCsv = true;
            if ($boolOutputFile === true) {
                $boolEchoCsv = false;
            }
            $strTempFile = 'csvOutput' . date("U") . ".csv";
            $f = fopen($strTempFile, "w+");
        }

        $firstLineKeys = false;
        foreach ($json as $line) {
            if (empty($firstLineKeys)) {
                $firstLineKeys = array_keys($line);
                fputcsv($f, $firstLineKeys, ";");
                $firstLineKeys = array_flip($firstLineKeys);
            }

            // Using array_merge is important to maintain the order of keys acording to the first element
            fputcsv($f, array_merge($firstLineKeys, $line), ';');
        }
        fclose($f);

        // Take the file and put it to a string/file for output (if no save path was included in function arguments)
        if ($boolOutputFile === true) {
            if ($csvFilePath !== false) {
                $file = $csvFilePath;
            } else {
                $file = $strTempFile;
            }

            // Output the file to the browser (for open/save)
            if (file_exists($file)) {

                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename=' . basename($file));

                header('Content-Length: ' . filesize($file));
                readfile($file);
            }
        } elseif ($boolEchoCsv === true) {
            if (($handle = fopen($strTempFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle)) !== FALSE) {
                    echo implode(",", $data);
                    echo "<br />";
                }
                fclose($handle);
            }
        }
        system('rm ' . $file);
    }
}
