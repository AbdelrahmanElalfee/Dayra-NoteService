<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Traits\Responses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NoteRepository implements NoteRepositoryInterface {

    use Responses;

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function create(array $attributes): JsonResponse
    {
        return DB::transaction(function () use ($attributes) {
            $created = Note::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'content' => data_get($attributes, 'content'),
                'user_id' => data_get($attributes, 'user_id')
            ]);

            throw_if(!$created, GeneralException::class, 'Failed to create');
            return $this->success(new NoteResource($created), 'Created', Response::HTTP_CREATED);
        });
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function update($model, array $attributes): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $model->update([
                'title' => $attributes['title'] ?? $model->title,
                'content' => $attributes['content'] ?? $model->content,
                'user_id' => $attributes['user_id'] ?? $model->user_id
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
        try {
            \DB::beginTransaction();
            $model->delete();
            \DB::commit();
            $this->success(null, '', Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }
}
