<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
                    'mobile' => ['nullable','required_without:wx_oauth','max:11','min:11','exists:users'],
                    'password' => ['nullable','required_without:wx_oauth'],
                    'wx_oauth' => ['required_without:mobile,password']
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
            'mobile.required_without'=>'wx_oauth不存在时手机号必须填写',
            'mobile.max' => '手机号长度为11个字符',
            'mobile.min' => '手机号长度为11个字符',
            'mobile.exists' => '该手机号没有注册',
            'password.required_without' => 'wx_oauth不存在时密码不能为空',
            'wx_oauth.required_without' => '手机号和密码不存在时必须微信认证'
        ];
    }
}
