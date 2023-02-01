<?php

namespace App\Http\Requests\Api\TicketReservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketReservationRequest extends FormRequest
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
            'price' => ['required', 'numeric'],
            'departure' => ['required', 'string', 'max:190'],
            'arrival' => ['required', 'string', 'max:190'],
            'child_count' => ['nullable', 'in:1,2,3,4'],
            'adult_count' => ['required', 'in:1,2,3,4'],
            'departure_at' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
            'arrive_at' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:departure_at'],
            'kind' => ['required', 'in:business,economic,premium'],
            'type' => ['required', 'in:Flights,Voyage,Trains,Busses,Microbuses,Limousine'],
            'provider_id' => ['required', 'exists:providers,id,deleted_at,NULL']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        throw new HttpResponseException(sendError('Validation Error.', [$validator->errors()->all()], 422));
    }
}
