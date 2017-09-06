<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\JWTAuthTrait;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;
    use JWTAuthTrait;

    public function testIndexSuccess()
    {
        $posts = factory(Post::class, 3)->create();

        $response = $this->get(route('v1.posts.index'));

        $response->assertStatus(200);
        $response->assertJson($posts->toArray());
    }

//    public function testCreateSuccess()
//    {
//        $post = factory(Post::class)->make();
//
//        $response = $this->postJson(route('v1.posts.create'), $post->toArray(), $this->getJWTHeader());
//
//        $response->assertStatus(201);
//        $response->assertJsonFragment($post->toArray());
//    }
}
