<?php

namespace App\Repositories;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

interface NoteRepositoryInterface {

    public function index();
    public function create(StoreNoteRequest $request);

    public function update($model, UpdateNoteRequest $request);

    public function destroy($model);
}
