<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                    'mobile' => ['required','max:11','min:11'],
                    'code' => ['required','max:6','min:6'],
                    'password' => ['required','max:20','min:6'],
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
            'mobile.required'=>'手机号必须填写',
            'mobile.max' => '手机号长度为11个字符',
            'mobile.min' => '手机号长度为11个字符',
            'code.required'=>'验证码必须填写',
            'code.max' => '验证码长度为6个字符',
            'code.min' => '验证码长度为6个字符',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过20个字符',
            'password.min' => '密码长度不能小于6个字符',
        ];
    }
}
