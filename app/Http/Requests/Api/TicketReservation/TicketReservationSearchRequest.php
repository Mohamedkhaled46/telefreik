<?php

namespace App\Http\Requests\Api\TicketReservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketReservationSearchRequest extends FormRequest
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
            'term' => ['nullable', 'string', 'min:3'],
            'ticket' => ['nullable', 'exists:ticket_reservations,id,deleted_at,NULL'],
            'status' => ['required', 'in:All,Waiting,Upcomming,Finished'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        throw new HttpResponseException(sendError('Validation Error.', [$validator->errors()->all()], 422));
    }
}
