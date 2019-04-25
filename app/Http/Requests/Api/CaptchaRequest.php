<?php

namespace App\Http\Requests\Api;

use App\Models\Enum\CaptchaEnum;
use Illuminate\Foundation\Http\FormRequest;

class CaptchaRequest extends FormRequest
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
                    'type' => ['string','required','in:'.implode(',',[CaptchaEnum::REGISTER,CaptchaEnum::RESET_PASSWORD,CaptchaEnum::BIND_WEICHAT])],
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
}
