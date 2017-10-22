<?php

namespace Tests\Feature;

use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;

class LikeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testToggleCreateSuccess()
    {
        $like = factory(Like::class)->make();

        Passport::actingAs(User::findorfail($like->user_id));
        $response = $this->putJson(route('v1.likes.toggle', $like->post_id), $like->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', $like->toArray());
    }

    public function testToggleRemoveSuccess()
    {
        $like = factory(Like::class)->create();
        $this->assertDatabaseHas('likes', $like->toArray());

        Passport::actingAs(User::findorfail($like->user_id));
        $response = $this->putJson(route('v1.likes.toggle', $like->post_id), $like->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseMissing('likes', $like->toArray());
    }

    public function testToggleSwitchSuccess()
    {
        $like = factory(Like::class)->create();
        $this->assertDatabaseHas('likes', $like->toArray());

        $like->status = !$like->status;

        Passport::actingAs(User::findorfail($like->user_id));
        $response = $this->putJson(route('v1.likes.toggle', $like->post_id), $like->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', $like->toArray());
        $like->status = !$like->status;
        $this->assertDatabaseMissing('likes', $like->toArray());
    }
}
