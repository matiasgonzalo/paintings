<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'data.attributes' => ['required', 'array:name,email,password'],
            'data.attributes.name' => ['required', 'string'],
            'data.attributes.email' => ['required', 'string'],
            'data.attributes.password' => ['required', 'string']
        ];
    }
}
