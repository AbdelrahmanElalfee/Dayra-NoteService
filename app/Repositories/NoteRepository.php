<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Traits\Responses;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NoteRepository extends Repository {

    use Responses;

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function create(array $attributes)
    {
        try {
            \DB::beginTransaction();
            $model = Note::create([
                'title' => data_get($attributes, 'title'),
                'content' => data_get($attributes, 'content'),
                'user_id' => data_get($attributes, 'user_id'),
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
    public function update($model, array $attributes)
    {
        try {
            \DB::beginTransaction();
            $model->update([
                'title' => data_get($attributes, 'title'),
                'content' => data_get($attributes, 'content'),
                'user_id' => data_get($attributes, 'user_id'),
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
    public function destroy($model)
    {
        try {
            \DB::beginTransaction();
            $model->delete();
            \DB::commit();
            return $this->success("", Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }
}