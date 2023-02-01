<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterMobileRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:customers,email'],
            'mobile' => ['required', 'unique:customers,mobile'],
            'phonecode' => ['required', 'exists:countries,phonecode'],
            'name' => ['required', 'string', 'max:255'],
            'firebase_token' => ['required', 'string', 'max:190'],
            'os_system' => ['required', 'string', 'max:190'],
            'os_version' => ['required', 'string', 'max:190']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        throw new HttpResponseException(sendError('Validation Error.', [$validator->errors()->all()], 422));
    }
}
