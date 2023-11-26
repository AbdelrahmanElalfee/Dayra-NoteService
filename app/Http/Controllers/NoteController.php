<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Traits\Responses;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function store(StoreNoteRequest $request): JsonResponse
    {
        $note = Note::create($request->all());
        return $this->success(new NoteResource($note), 'Created', Response::HTTP_CREATED);
    }

    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        $note->update($request->all());
        return $this->success(new NoteResource($note), 'Created', Response::HTTP_CREATED);
    }

    public function destroy(Note $note): JsonResponse
    {
        $note->delete();
        return $this->success("", Response::HTTP_NO_CONTENT);
    }
}
