<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        return [
            'name'=>['required','string','min:1','max:190'],
            'title'=>['required','string','min:1','max:190'],
            'brief'=>['required','string','min:1','max:190'],
            'button_link'=>['required','string','min:1','max:190'],
            'button_text'=>['required','string','min:1','max:190'],
            'icon'=>['required','min:1','max:190'],
            'image'=>['required','min:1','max:190'],
            'description'=>['required','min:1','max:500'],

        ];
    }
}
