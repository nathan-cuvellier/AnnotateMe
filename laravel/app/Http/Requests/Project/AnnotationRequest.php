<?php

namespace App\Http\Requests\Project;

use App\Data;
use App\Category;
use App\ConfidenceInterval;
use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class AnnotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * The min and max correspond at the constraints in database
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $project = Project::query()->where('id_prj', $this->route('id'))->first();

        $reqCategory = Category::query()
            ->select('id_cat')
            ->where('id_prj', $this->route('id'))
            ->get(); // select categories from id in URL (param id)

        $categoriesId = array_map(function($v) {
            return $v['id_cat'];
        }, $reqCategory->toArray());

        $reqData = Data::query()
            ->select('id_data')
            ->where('id_prj', $this->route('id'))
            ->get(); // select categories from id in URL (param id)

        $datasId = array_map(function($v) {
            return $v['id_data'];
        }, $reqData->toArray());

        $idValideConfidenceLevel = (int) $request->expert_sample_confidence_level;

        $reqConfidencesLevel = ConfidenceInterval::query()
                ->select('id_confidence_interval')
                ->get();

        $ConfidencesLevelId = array_map(function($v) {
            return $v['id_confidence_interval'];
        }, $reqConfidencesLevel->toArray());

        $rules = [
            'category' => 'required|in:'. implode(',', $categoriesId),
            'expert_sample_confidence_level' => 'required',
        ];

        if($project->id_int == 1) {
            $rules['id_data'] =  'required|in:' . implode(',', $datasId);
        } else if($project->id_int == 2) {
            $rules['id_data1'] =  'required|in:' . implode(',', $datasId);
            $rules['id_data2'] =  'required|in:' . implode(',', $datasId);
        }

        return $rules;
    }
}
