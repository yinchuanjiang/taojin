<?php

namespace App\Http\Requests\Api;

use App\Models\Enum\PayEnum;
use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
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
                    'type' => ['required','in:'.implode(PayEnum::ALIAPY,PayEnum::WECHAT_APP_PAY)],
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
            'quantity.required'=>'数量必须填写',
            'quantity.numeric' => '数量必须是数字',
        ];
    }
}
