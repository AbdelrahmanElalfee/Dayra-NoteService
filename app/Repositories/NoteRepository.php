<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Helpers\UserInternalApi;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Traits\Responses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NoteRepository implements NoteRepositoryInterface {

    use Responses;

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function create(StoreNoteRequest $request): JsonResponse
    {
        $token = $request->bearerToken();

        return DB::transaction(function () use ($request, $token) {
            $created = Note::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'user_id' => UserInternalApi::getUserId($token)
            ]);

            throw_if(!$created, GeneralException::class, 'Failed to create');
            return $this->success(new NoteResource($created), 'Created', Response::HTTP_CREATED);
        });
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function update($model, UpdateNoteRequest $request): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $model->update([
                'title' => $request->input('title') ?? $model->title,
                'content' => $request->input('content') ?? $model->content,
            ]);
            \DB::commit();
            return $this->success(new NoteResource($model), 'Updated');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function destroy($model): JsonResponse
    {
        throw_if(
            Auth::id() !== $model->user_id,
            GeneralException::class,
            "Unauthorized",
            Response::HTTP_UNAUTHORIZED
        );
        try {
            \DB::beginTransaction();
            $model->delete();
            \DB::commit();
            return $this->success(null, '', Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }


    public function index(): JsonResponse
    {
        $notes = Note::where('user_id',  Auth::id())->get();
        return $this->success(NoteResource::collection($notes), 'Retrieved');
    }
}
