<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email:rfc,filter', 'string', 'unique:users,email', 'max:255'],
            'password' => ['required'],
            'file' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'role_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        throw new HttpResponseException(sendError('Validation Error.', [$validator->errors()->all()], 422));
    }
}
