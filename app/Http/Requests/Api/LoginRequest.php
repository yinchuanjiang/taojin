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
                    'mobile' => ['required_without:wx_oauth','max:11','min:11','exists:users'],
                    'password' => ['required_without:wx_oauth','max:20','min:6'],
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
            'mobile.exists' => '手机号或密码错误',
            'password.required_without' => 'wx_oauth不存在时密码不能为空',
            'password.max' => '密码长度不能超过20个字符',
            'password.min' => '密码长度不能小于6个字符',
            'wx_oauth.required_without' => '手机号和密码不存在时必须微信认证'
        ];
    }
}
