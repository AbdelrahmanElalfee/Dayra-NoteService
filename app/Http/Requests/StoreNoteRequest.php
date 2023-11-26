<?php

namespace App\Http\Requests;

use App\Exceptions\GeneralException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreNoteRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];
    }

    /**
     * @throws GeneralException
     */
    public function failure($validator)
    {
        throw (new GeneralException($validator->errors()->first(),Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
