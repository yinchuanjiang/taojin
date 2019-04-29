<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
                    'to_name' => ['required','max:191'],
                    'mobile' => ['required','max:11','min:11'],
                    'address' => ['required','string'],
                    'detail' => ['required','max:191'],
                    'postcode' => ['nullable','max:6'],
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
            'to_name.required'=>'收件人必须填写',
            'to_name.max' => '收件人最多为191个字符',
            'mobile.required'=>'手机号必须填写',
            'mobile.max' => '手机号长度为11个字符',
            'mobile.min' => '手机号长度为11个字符',
            'address.required' => '区不能为空',
            'address.string' => '区数据必须是字符串',
            'detail.required'=>'详细地址必须填写',
            'detail.max' => '详细地址最多为191个字符',
            'postcode.max'=>'邮政编码最多6个字符',
        ];
    }
}
