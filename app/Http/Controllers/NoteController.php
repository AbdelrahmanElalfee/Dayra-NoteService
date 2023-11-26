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
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{
    use Responses;

    protected $repository;

    public function __construct(NoteRepository $repository)
    {
        $this->$repository = $repository;
    }

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
     */
    public function store(StoreNoteRequest $request): JsonResponse
    {
        $created = $this->repository->create($request->all());
        return $this->success(new NoteResource($created), 'Created', Response::HTTP_CREATED);
    }


    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        $updated = $this->repository->update($note, $request->all());
        return $this->success(new NoteResource($updated), 'Updated');
    }


    /**
     * @throws Throwable
     * @throws GeneralException
     */
    public function destroy(Note $note): JsonResponse
    {
        $deleted = $this->repository->destroy($note);
        return $this->success(null, '', Response::HTTP_NO_CONTENT);
    }
}
