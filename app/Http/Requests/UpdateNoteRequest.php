<?php

namespace App\Http\Requests;

use App\Traits\Responses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateNoteRequest extends FormRequest
{

    use Responses;

    public function rules(): array
    {
        return [
            'title' => ['string'],
            'content' => ['string'],
        ];
    }

    public function failedValidation($validator)
    {
        $response= $this->failure($validator->errors()->first(),422);

        throw (new ValidationException($validator, $response))->status(422);
    }
}
