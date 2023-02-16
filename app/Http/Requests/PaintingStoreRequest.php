<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaintingStoreRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => ['required', 'array:type,attributes'],
            'data.type' => ['required', 'string'],
            'data.attributes' => ['required', 'array:code,name,painter,country,date,style,width,hight'],
            'data.attributes.code' => ['required', 'string'],
            'data.attributes.name' => ['required', 'string'],
            'data.attributes.painter' => ['required', 'string'],
            'data.attributes.country' => ['required', 'string'],
            'data.attributes.date' => ['required', 'date_format:Y-m-d'],
            'data.attributes.style' => ['required', 'string'],
            'data.attributes.width' => ['required', 'integer'],
            'data.attributes.hight' => ['required', 'integer']
        ];
    }
}
