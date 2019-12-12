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
    function indexExport($id_prj)
    {
        
       $annot = json_decode(Annotation::first(),true);
        /*switch (Project::find($id_prj)->id_int) {
            case 1:
                $annot = json_decode(Annotation::first(),true);
                break;
            case 2:
                $annot = json_decode(Pairwise::first(),true);
                break;
            case 3:
                $annot = json_decode(Triplewise::first(),true);
                break;
        }*/


        /*header('Content-Disposition: attachment; filename="export.csv"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");*/
        
        return view("project/export",["id_prj"=>$id_prj, "annot"=>$annot]);

    }

    function indexExportConfirm($id_prj)
    {
        return view("project/confirmExport",["id_prj"=>$id_prj]);
    }





    function exportDatas(ExportRequest $request, $id_prj)
    {
        $pathCSV = "./source/storage/app/csv/$id_prj";
        $resExport = $this->createCSV($pathCSV, $id_prj, $request->input('columExport'),$request->input('machineLearning'));
        if(!$resExport)
        {
            session()->put('message','You can\'t export the project : He has no annotation'); //message on list page
            return redirect('/projects'); /* Return to the projects list page*/
        }
        return redirect("/project/$id_prj/exportConfirm");
    }

    function downloadDatas($id_prj)
    {
        $prj = Project::find($id_prj);
        $path = "./source/storage/app/csv/$id_prj";
        $file = $path."/CSVproject".$id_prj."_".$prj->name_prj.".csv";

        $headers = [
            'Content-Type' => 'application/pdf',
        ];
          return Response::download($file,'filename.pdf',$headers);
       // return response()->download($file);
    }

    private function createCSV($path, $id_prj, $fields, $isMachinLearning)
    {
        $prj = Project::find($id_prj);


        if(!is_dir($path))
            mkdir($path);

        $annotationTitles = [];


        //Variable depends of it interface
        switch ($prj->id_int) {
            case 1:
                $nameTable = "App\Annotation";
                $name_id = "id_annot";
                $name_data1 = "id_data";
                $name_data2 = null;
                $name_data3 = null;
                $titles = array('element');

                break;
            case 2:
                $nameTable = "App\Pairwise";
                $name_id = "id_pair";
                $name_data1 = "id_data1";
                $name_data2 = "id_data2";
                $name_data3 = null;
                $titles = array('element1','element2');
                break;
            case 3:
                $nameTable = "App\Triplewise";
                $name_id = "id_triplet";
                $name_data1 = "id_data1";
                $name_data2 = "id_data2";
                $name_data3 = "id_data3";
                $titles = array('element1','element2','element3');
                break;
        }


        // Get all of the project's annotation
        $allDatas = Data::where('id_prj',$id_prj)->get();
        foreach ($allDatas as $key => $data)
        {
            $annot = $nameTable::whereIn($name_data1,[$data->id_data])->get();
            foreach ($annot as $key => $value) {
                $annotations[] =  $value;
            }
        }

        //If the project has no annotation -> redirect to the project list
        if(empty($annotations))
        {
            return false;
        }

        //Create all the tuple function of the project's Interface
        switch ($prj->id_int) {
            case 1:
                $allTuple = $allDatas;
                break;
            case 2:
                $allTuple = ExportController::createTuple($allDatas, 2);
                break;
            case 3:
                $allTuple = ExportController::createTuple($allDatas, 3);
                break;
        }

        $annotDatas = array();

        foreach ($allTuple as $key => $value)
        {
            $annotDatas[$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3] = array();

            foreach ($annotations as $key => $annotation)
            {
                if($value->$name_data1." ".$value->$name_data2." ".$value->$name_data3 == $annotation->$name_data1." ".$annotation->$name_data2." ".$annotation->$name_data3
                    ||$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3 == $annotation->$name_data1." ".$annotation->$name_data3." ".$annotation->$name_data2
                    ||$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3 == $annotation->$name_data2." ".$annotation->$name_data1." ".$annotation->$name_data3
                    ||$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3 == $annotation->$name_data2." ".$annotation->$name_data3." ".$annotation->$name_data1
                    ||$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3 == $annotation->$name_data3." ".$annotation->$name_data1." ".$annotation->$name_data2
                    ||$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3 == $annotation->$name_data3." ".$annotation->$name_data2." ".$annotation->$name_data1)
                {
                    $annotDatas[$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3] = array_merge($annotDatas[$value->$name_data1." ".$value->$name_data2." ".$value->$name_data3], [$annotation]);
                }

            }

        }


        // Get the most annotated data
        if($isMachinLearning == "user")
        {
            $maxAnnot = 0;
            foreach ($annotDatas as $idData => $annotData)
            {
                if($maxAnnot < count($annotData))
                {
                    $maxAnnot = count($annotData);
                }
            }
        }else
        {
            $maxAnnot = 1;
        }
        // Setting titles
        $k = 0;
        for($i = 0; $i < $maxAnnot; $i++)
        {
            for($j = 0; $j < count($fields); $j++)
            {
                $annotationTitles[$i+$k] = $fields[$j].($i+1);
                $k++;
            }
        }

        $titles = array_merge($titles, $annotationTitles);

        // Creation of the CSV
        $csv = fopen($path."/CSVproject".$id_prj."_".$prj->name_prj.".csv", "w+");
        fputcsv($csv, $titles,";");

        //Run all the tuple of the project
        foreach ($annotDatas as $idData => $annotData)
        {
            if(!empty($annotData))
            {
                $annotationDatas = array();

                $k = 0;

                switch ($prj->id_int) {
                    case 1:
                        $datas = [Data::Find($annotData[0]->id_data)->pathname_data];
                        break;
                    case 2:
                        $datas = [Data::Find($annotData[0]->id_data1)->pathname_data, Data::Find($annotData[0]->id_data2)->pathname_data];
                        break;
                    case 3:
                        $datas = [Data::Find($annotData[0]->id_data1)->pathname_data, Data::Find($annotData[0]->id_data2)->pathname_data, Data::Find($annotData[0]->id_data3)->pathname_data];
                        break;
                }

                //EXPORT NOT FOR MACHINLEARNING
                if($isMachinLearning == "user")
                {
                    for ($i = 0; $i < count($annotData); $i++)
                    {
                        $annotation = $nameTable::Find($annotData[$i]->$name_id);

                        for($j = 0; $j < count($fields); $j++)
                        {
                            $field = $fields[$j];

                            if($field == "id_cat")
                            {
                                $annotationDatas[$i*count($fields)+$k] =Category::Find($annotation->id_cat)['label_cat'] ;
                            }
                            else
                            {
                                $annotationDatas[$i*count($fields)+$k] = $annotation->$field;
                            }
                            $k++;
                        }
                    }

                    $datas = array_merge($datas,$annotationDatas);
                    fputcsv($csv, $datas,";");

                }else //FOR MACHING LEARNING
                {
                    foreach ($annotData as $aAnnotData) {
                        $k = 0;
                        foreach ($fields as $afield) {
                            if($afield == "label_cat")
                            {
                                $annotationDatas[$k] =Category::Find($aAnnotData->id_cat)['label_cat'] ;
                            }
                            else
                            {
                                $annotationDatas[$k] = $aAnnotData->$afield;
                            }
                            $k++;
                        }
                        fputcsv($csv, array_merge($datas,$annotationDatas),";");
                    }


                }
            }



        }
        fclose($csv);
        return true;
    }

    public static function createTuple($datas, int $nbTuple){
        $nbDatasToTuple = $datas->count();
        $startFor = 0;

        switch ($nbTuple) {
            case 2:
                foreach ($datas as $aData) {
                    for($i=$startFor;$i<$nbDatasToTuple-1;$i++)
                    {

                        $s = new Pairwise();
                        $s->id_exp = session()->get('idExp');
                        $s->id_data1 = $aData->id_data;
                        $s->id_data2 = $datas[$i+1]->id_data;
                        $res[] = $s;

                    }
                    $startFor ++;
                }
                break;

            case 3:
                $startFor2 = 0;

                for($a=$startFor;$a<$nbDatasToTuple-2;$a++)
                {
                    for($b=$a + 1;$b<$nbDatasToTuple;$b++)
                    {
                        for($c=$b + 1;$c<$nbDatasToTuple;$c++)
                        {
                            $s = new Triplewise();
                            $s->id_exp = session()->get('idExp');
                            $s->id_data1 = $datas[$a]->id_data;
                            $s->id_data2 = $datas[$b]->id_data;
                            $s->id_data3 = $datas[$c]->id_data;
                            $res[] = $s;
                        }
                    }
                }
                break;

            default:
                return false;
                break;
        }
        return $res;
    }
}
