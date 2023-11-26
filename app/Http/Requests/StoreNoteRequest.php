<?php

namespace App\Http\Requests;

use App\Traits\Responses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreNoteRequest extends FormRequest
{

    use Responses;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];
    }

    public function failedValidation($validator)
    {
        $response= $this->failure($validator->errors()->first(),422);

        throw (new ValidationException($validator, $response))->status(422);
    }
}
