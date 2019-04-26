<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
                    'good_id' => ['required','numeric'],
                    'quantity' => ['required','numeric']    ,
                    'address' => ['required','numeric'],
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
            'good_id.required' => '商品id不能为空',
            'good_id.numeric' => '商品id必须是数字',
            'quantity.required'=>'数量必须填写',
            'quantity.numeric' => '数量必须是数字',
            'address.required' => '地址不能为空',
            'address.numeric' => '地址必须是数字',
        ];
    }
}
