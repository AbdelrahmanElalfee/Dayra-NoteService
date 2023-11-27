<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Note;
use App\Traits\Responses;
use Illuminate\Support\Facades\DB;
use Throwable;

class NoteRepository implements NoteRepositoryInterface {

    use Responses;

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function create(array $attributes): Note
    {
        return DB::transaction(function () use ($attributes) {
            $created = Note::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'content' => data_get($attributes, 'content'),
                'user_id' => data_get($attributes, 'user_id')
            ]);

            throw_if(!$created, GeneralException::class, 'Failed to create');
            return $created;
        });
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function update($model, array $attributes): Note
    {
        try {
            \DB::beginTransaction();
            $model->update([
                'title' => $attributes['title'] ?? $model->title,
                'content' => $attributes['content'] ?? $model->content,
                'user_id' => $attributes['user_id'] ?? $model->user_id
            ]);
            \DB::commit();
            return $model;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function destroy($model): void
    {
        try {
            \DB::beginTransaction();
            $model->delete();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }
}
