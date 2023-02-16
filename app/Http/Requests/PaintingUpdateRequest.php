<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PaintingUpdateRequest extends FormRequest
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
            'data.attributes.code' => ['required', 'string', 'max:255', Rule::unique('paintings', 'code')->ignore($this->route('painting'))],
            'data.attributes.name' => ['required', 'string', 'max:255', Rule::unique('paintings', 'name')->ignore($this->route('painting'))],
            'data.attributes.painter' => ['required', 'string', 'max:255'],
            'data.attributes.country' => ['required', 'string', 'max:255'],
            'data.attributes.date' => ['required', 'date_format:Y-m-d'],
            'data.attributes.style' => ['required', 'string', 'max:120'],
            'data.attributes.width' => ['required', 'integer', 'min:10'],
            'data.attributes.hight' => ['required', 'integer', 'min:10']
        ];
    }
}
