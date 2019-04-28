<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
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
                    'cash' => ['required','numeric'],
                    'account' => ['required','string'],
                    'real_name' => ['required'],
                    'bank_of_deposit' => ['nullable']
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
            'cash.required'=>'金额必须填写',
            'cash.numeric' => '金额必须是数字',
            'account.required'=>'收款账户不能为空',
            'account.account' => '收款账户必须是字符串',
            'real_name.required' => '姓名不能为空',
        ];
    }
}
