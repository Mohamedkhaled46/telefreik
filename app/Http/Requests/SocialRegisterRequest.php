<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialRegisterRequest extends FormRequest
{
    public $validator = null;

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
        return [
            'SUUID' => ['required', 'string'],
            'loggedBy' => ['required', 'in:facebook,google'],
            'image' => ['nullable', 'url'],
            'email' => ['required', 'email:rfc,filter', 'string'],
            'mobile' => ['required'],
            'phonecode' => ['required', 'exists:countries,phonecode'],
            'name' => ['required', 'string', 'max:255'],
            'firebase_token' => ['required'],
            'os_system' => ['required'],
            'os_version' => ['required']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        throw new HttpResponseException(sendError('Validation Error.', [$validator->errors()->all()], 422));
    }
}
