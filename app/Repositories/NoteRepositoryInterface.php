<?php

namespace App\Repositories;

interface NoteRepositoryInterface {

    public function create(array $attributes);

    public function update($model, array $attributes);

    public function destroy($model);
}
