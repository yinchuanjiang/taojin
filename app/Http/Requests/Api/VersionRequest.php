<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VersionRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'POST':
            {
                return [
                    'version' => ['required'],
                    'type' => ['required','in:IOS,ANDROID'],
                ];
            }
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default: {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            'version.required'=>'版本号必须填写',
            'type.required' => '类型必须填写',
            'type.in' => '类型只能是IOS和ANDROID'
        ];
    }
}
