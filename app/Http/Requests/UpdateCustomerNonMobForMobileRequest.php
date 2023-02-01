<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerNonMobForMobileRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'min:1', 'max:255'],
            'email' => ['nullable', 'email:rfc,filter', 'unique:customers,email,' . $this->user('customer-api')->id, 'max:255'],
            'file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        throw new HttpResponseException(sendError('Validation Error.', [$validator->errors()->all()], 422));
    }
}
