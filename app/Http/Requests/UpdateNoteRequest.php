<?php

namespace App\Http\Requests;

use App\Exceptions\GeneralException;
use App\Helpers\UserInternalApi;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @throws GeneralException
     */
    public function authorize(): bool
    {
        $note = $this->route('note');
        $token = $this->bearerToken();
        return UserInternalApi::getUserId($token) === $note->user_id;
    }

    public function rules(): array
    {
        return [
            'title' => ['string'],
            'content' => ['string'],
        ];
    }

    /**
     * @throws GeneralException
     */
    public function failure($validator)
    {
        throw (new GeneralException($validator->errors()->first(),Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     *
     * @throws GeneralException
     */
    protected function failedAuthorization()
    {
        throw new GeneralException(
            'Unauthorized',
            Response::HTTP_UNAUTHORIZED
        );
    }
}
