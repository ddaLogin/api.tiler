<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexSuccess()
    {
        $posts = factory(Post::class, 3)->create();

        $response = $this->get(route('v1.posts.index'));

        $response->assertStatus(200);
        $response->assertJson($posts->toArray());
    }

    public function testCreateSuccess()
    {
        $post = factory(Post::class)->make();

        Passport::actingAs(User::findorfail($post->user_id));
        $response = $this->postJson(route('v1.posts.create', $post->user_id), $post->toArray());

        $response->assertStatus(201);
        $response->assertJsonFragment($post->toArray());
    }

    public function testCreateFailValidation()
    {
        Passport::actingAs(User::findorfail(1));
        $response = $this->postJson(route('v1.posts.create', 1));

        $data = [
            'title' => [trans('validation.required', ['attribute' => 'title'])],
            'text' => [trans('validation.required', ['attribute' => 'text'])],
        ];
        $response->assertStatus(422);
        $response->assertJsonFragment($data);
    }

    public function testCreateFailAccessDenied()
    {
        $fakeUser = factory(User::class)->create();
        $post = factory(Post::class)->make();

        Passport::actingAs(User::findorfail(1));
        $response = $this->postJson(route('v1.posts.create', $fakeUser->id), $post->toArray());

        $response->assertStatus(403);
    }

    public function testCreateFailToAlienCollection()
    {
        $collection = factory(Collection::class)->create();
        $post = factory(Post::class)->make(['collections' => [$collection->id]]);

        Passport::actingAs(User::findorfail($post->user_id));
        $response = $this->postJson(route('v1.posts.create', $post->user_id), $post->toArray());
        $response->assertStatus(422);
    }

    public function testShowSuccess()
    {
        $post = factory(Post::class)->create();

        $response = $this->get(route('v1.posts.show', $post->id));
        $response->assertStatus(200);
        $response->assertJson($post->toArray());
    }

    public function testGetUsersPostSuccess()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 3)->create(['user_id' => $user->id, 'preview' => null]);
        foreach ($posts as $post){
            $post->collections = [];
            $post->categories = [];
            $post->likes = [];
            $post->dislikes = [];
        }

        $response = $this->get(route('v1.posts.byUser', $user->id));
        $response->assertStatus(200);
        $response->assertJsonFragment([$posts->toArray()]);
    }
}
