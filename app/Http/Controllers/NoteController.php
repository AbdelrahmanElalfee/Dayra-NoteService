<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Note;
use App\Traits\Responses;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\NoteResource;
use App\Exceptions\GeneralException;
use App\Repositories\NoteRepository;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

class NoteController extends Controller
{
    use Responses;

    public function index(NoteRepository $repository): JsonResponse
    {
        return $repository->index();
    }

    public function show(Note $note): JsonResponse
    {
        return $this->success(new NoteResource($note), "Retrieved");
    }

    /**
     * @throws Throwable
     */
    public function store(StoreNoteRequest $request, NoteRepository $repository): JsonResponse
    {
        return $repository->create($request);
    }


    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function update(UpdateNoteRequest $request, Note $note, NoteRepository $repository): JsonResponse
    {
        return $repository->update($note, $request);
    }


    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function destroy(Note $note, NoteRepository $repository): JsonResponse
    {
        return $repository->destroy($note);
    }
}
