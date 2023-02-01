<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgotPasswordRequest extends FormRequest
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
            'email' => ['required', 'email:rfc,filter', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        throw new HttpResponseException(sendError('Validation Error.', [$validator->errors()->all()], 422));
    }
}
