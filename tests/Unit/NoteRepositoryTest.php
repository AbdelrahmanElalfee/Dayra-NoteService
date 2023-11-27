<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Repositories\NoteRepository;
use PHPUnit\Framework\TestCase;

class NoteRepositoryTest extends TestCase
{
    private $app;

    public function test_create() {
        $repository = $this->app->make(NoteRepository::class);

        $payload = [
            'title' => fake()->title,
            'content' => fake()->text(),
            'user_id' => fake()->randomNumber()
        ];

        $created = $repository->create($payload);

        $this->assertSame($payload['title'], $created->title);
    }

    public function test_update() {
        $repository = $this->app->make(NoteRepository::class);

        $note = Note::create([
            'title' => fake()->title,
            'content' => fake()->text,
            'user_id' => fake()->randomNumber()
        ]);

        $payload = [
            'title' => fake()->title
        ];

        $updated = $repository->update($note, $payload);
        $this->assertSame($payload['title'], $updated->title);
    }

    public function test_delete() {
        $repository = $this->app->make(NoteRepository::class);

        $note = Note::create([
            'title' => fake()->title,
            'content' => fake()->text,
            'user_id' => fake()->randomNumber()
        ]);

        $deleted = $repository->destroy($note);

        $check = Note::query()->find($note->id);

        $this->assertSame(null, $check);
    }
}
