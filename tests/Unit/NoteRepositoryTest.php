<?php

namespace Tests\Unit;

use App\Exceptions\GeneralException;
use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        $repository = $this->app->make(NoteRepository::class);
        $payload = [
            'title' => fake()->title,
            'content' => fake()->text,
            'user_id' => fake()->randomNumber()
        ];
        $result = $repository->create($payload);
        $this->assertSame($payload['title'], $result->title, 'Post created does not have the same title.');
    }

    public function test_update()
    {
        $repository = $this->app->make(NoteRepository::class);
        $note = Note::factory()->create();
        $payload = [
            'title' => 'Test',
        ];
        $updated = $repository->update($note, $payload);
        $this->assertSame($payload['title'], $updated->title, 'Post updated does not have the same title.');
    }

    public function test_delete()
    {
        $repository = $this->app->make(NoteRepository::class);
        $note = Note::factory()->create();
        $repository->destroy($note);
        $found = Note::find($note->id);
        $this->assertSame(null, $found, 'Post is not deleted');
    }

}
