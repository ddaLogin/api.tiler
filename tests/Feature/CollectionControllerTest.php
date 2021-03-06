<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateSuccess()
    {
        $collection = factory(Collection::class)->make();

        Passport::actingAs(User::findorfail($collection->user_id));
        $response = $this->postJson(route('v1.collections.create', $collection->user_id), $collection->toArray());

        $response->assertStatus(201);
        $response->assertJsonFragment($collection->toArray());
        $this->assertDatabaseHas('collections', $collection->toArray());
    }

    public function testCreateFailAccessDenied()
    {
        $collection = factory(Collection::class)->make();

        Passport::actingAs(User::findorfail(1));
        $response = $this->postJson(route('v1.collections.create', $collection->user_id), $collection->toArray());

        $response->assertStatus(403);
    }

    public function testCreateFailValidation()
    {
        Passport::actingAs(User::findorfail(1));
        $response = $this->postJson(route('v1.collections.create', 1));

        $data = [
            'name' => [trans('validation.required', ['attribute' => 'name'])],
        ];
        $response->assertStatus(422);
        $response->assertJsonFragment($data);
    }

    public function testByUser()
    {
        $collections = factory(Collection::class, 5)->create(['user_id' => 1]);

        $response = $this->get(route('v1.collections.byUser', 1));
        $response->assertStatus(200);
        $response->assertJsonFragment([$collections->toArray()]);
    }

    public function testUpdateSuccess()
    {
        $collection = factory(Collection::class)->create();
        $this->assertDatabaseHas('collections', $collection->toArray());

        $collection->name = 'Name after update';
        Passport::actingAs(User::findorfail($collection->user_id));
        $response = $this->putJson(route('v1.collections.update', [$collection->id]), $collection->toArray());

        $response->assertStatus(200);
        $response->assertJsonFragment($collection->toArray());
        $this->assertDatabaseHas('collections', $collection->toArray());
    }

    public function testUpdateAlienAndFail()
    {
        $secondUser = factory(User::class)->create();
        $alienCollection = factory(Collection::class)->create(['user_id' => $secondUser->id]);
        $this->assertDatabaseHas('collections', $alienCollection->toArray());

        $alienCollection->name = 'Name after update';
        Passport::actingAs(User::findorfail(1));
        $response = $this->putJson(route('v1.collections.update', [$alienCollection->id]), $alienCollection->toArray());

        $response->assertStatus(403);
        $this->assertDatabaseMissing('collections', $alienCollection->toArray());
    }

    public function testDeleteSuccess()
    {
        $collection = factory(Collection::class)->create();
        $this->assertDatabaseHas('collections', $collection->toArray());

        Passport::actingAs(User::findorfail($collection->user_id));
        $response = $this->delete(route('v1.collections.delete', [$collection->id]));

        $response->assertStatus(200);
        $response->assertJsonFragment([]);
        $this->assertDatabaseMissing('collections', $collection->toArray());
    }

    public function testDeleteAlienAndFail()
    {
        $collection = factory(Collection::class)->create();
        $this->assertDatabaseHas('collections', $collection->toArray());

        Passport::actingAs(User::findorfail(1));
        $response = $this->delete(route('v1.collections.delete', [$collection->id]));

        $response->assertStatus(403);
        $this->assertDatabaseHas('collections', $collection->toArray());
    }
}
