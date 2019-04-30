<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BindRequest extends FormRequest
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
                    'avatar' => ['required'],
                    'wx_oauth' => ['required'],
                    'password' => ['nullable','min:6','max:20']
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
            'avatar.required' => '头像不能为空',
            'wx_oauth.required' => '微信授权标示不能为空',
            'password.max' => '密码长度最短为6个字符',
            'password.min' => '密码长度最长为20个字符',
        ];
    }
}
