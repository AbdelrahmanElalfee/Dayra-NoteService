<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Traits\Responses;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NoteController extends Controller
{
    use Responses;

    public function index(): JsonResponse
    {
        return $this->success(NoteResource::collection(Note::all()), "Retrieved");
    }

    public function show(Note $note): JsonResponse
    {
        return $this->success(new NoteResource($note), "Retrieved");
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function store(StoreNoteRequest $request): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $note = Note::create($request->all());
            \DB::commit();
            return $this->success(new NoteResource($note), 'Created', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $note->update($request->all());
            \DB::commit();
            return $this->success(new NoteResource($note), 'Updated', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function destroy(Note $note): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $note->delete();
            \DB::commit();
            return $this->success("", Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }
}
