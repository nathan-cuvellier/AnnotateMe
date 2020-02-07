<?php

namespace App\Http\Requests\Project;

use App\Data;
use App\Category;
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

        //dd(in_array($request->category, $categoriesId));

        return [
            'category' => 'required|in:'. implode(',', $categoriesId),
            'id_data' => 'required|in:' . implode(',', $datasId),
            'expert_sample_confidence_level' => 'required|min:1|max:3',
        ];
    }
}
