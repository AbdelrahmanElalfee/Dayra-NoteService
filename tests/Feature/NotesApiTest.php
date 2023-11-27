<?php

namespace Tests\Feature;

use App\Models\Note;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class NotesApiTest extends TestCase
{

    use RefreshDatabase;

    protected $uri = '/api/note';

    public function test_index(){
        $notes = Note::factory(10)->create();
        $notesId = $notes->map(fn($notes) => $notes->id);

        $response = $this->json('get', $this->uri);
        $response->assertStatus(Response::HTTP_OK);

        $data = $response->json('data');
        collect($data)->each(fn($notes) => $this->assertTrue(in_array($notes['id'], $notesId->toArray())));
    }

    public function test_show(){
        $note = Note::factory()->create();

        $response = $this->json('get', $this->uri . '/' . $note->id);
        $result = $response->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals(data_get($result, 'id'), $note->id);
    }

    public function test_store(){
        $note = Note::factory()->make();

        $response = $this->json('post', $this->uri, $note->toArray());

        $result = $response->assertStatus(Response::HTTP_CREATED)->json('data');
        $result = collect($result)->only(array_keys($note->getAttributes()));
        $result->each(function ($value, $field) use($note){
            $this->assertSame(data_get($note, $field), $value);
        });
    }

    public function test_update(){
        $note = Note::factory()->create();
        $demoNote = Note::factory()->make();

        $fillable = collect((new Note())->getFillable());
        $fillable->each(function ($toUpdate) use($note, $demoNote){
            $response = $this->json('patch', $this->uri . '/' . $note->id, [
                $toUpdate => data_get($demoNote, $toUpdate),
            ]);

            $result = $response->assertStatus(Response::HTTP_OK)->json('data');
            $this->assertSame(data_get($demoNote, $toUpdate), data_get($note->refresh(), $toUpdate),'Failed to update model.');
        });
    }

    public function test_destroy(){
        $note = Note::factory()->create();

        $response = $this->json('delete', $this->uri . '/' . $note->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->expectException(ModelNotFoundException::class);
        Note::findOrFail($note->id);
    }
}
