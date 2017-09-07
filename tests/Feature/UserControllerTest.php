<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\JWTAuthTrait;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use JWTAuthTrait;

    public function testCreateSuccess()
    {
        $user = factory(User::class)->make(['password' => 'secret']);
        $user->password_confirmation = 'secret';
        $data = $user->toArray();
        $data['password'] = 'secret';

        $response = $this->postJson(route('v1.users.create'), $data);

        $data = [
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
        ];
        $response->assertStatus(201);
        $response->assertJsonFragment($data);
        $this->assertDatabaseHas('users', $data);
    }

    public function testCreateFail()
    {
        $response = $this->postJson(route('v1.users.create'), []);

        $data = [
            'name' => [trans('validation.required', ['attribute' => 'name'])],
            'email' => [trans('validation.required', ['attribute' => 'email'])],
            'password' => [trans('validation.required', ['attribute' => 'password'])],
        ];
        $response->assertStatus(422);
        $response->assertJsonFragment($data);

        $response = $this->postJson(route('v1.users.create'), [
            'email' => 'admin@gmail.com'
        ]);

        $data = [
            'name' => [trans('validation.required', ['attribute' => 'name'])],
            'email' => [trans('validation.unique', ['attribute' => 'email'])],
            'password' => [trans('validation.required', ['attribute' => 'password'])],
        ];
        $response->assertStatus(422);
        $response->assertJsonFragment($data);
    }

    public function testAuthSuccess()
    {
        $response = $this->postJson(route('v1.auth'), ['email' => 'admin@gmail.com', 'password' => 'admin']);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'surname', 'email', 'created_at', 'updated_at', 'token']);
    }

    public function testAuthFail()
    {
        $response = $this->postJson(route('v1.auth'), ['email' => 'fake_email', 'password' => 'fake_password']);

        $response->assertStatus(401);
        $response->assertJson(['error' => trans('auth.failed')]);
    }

    public function testShowSuccess()
    {
        $response = $this->get(route('v1.users.show', 1), $this->getJWTHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(['name', 'surname', 'email', 'created_at', 'updated_at']);
    }

    public function testUpdateSuccess()
    {
        $newUserData = factory(User::class)->make()->toArray();
        $newUserData['password'] = 'secret';
        $newUserData['password_confirmation'] = 'secret';
        $newUserData['current_password'] = 'admin';
        $response = $this->putJson(route('v1.users.update', 1), $newUserData, $this->getJWTHeader());

        $data = [
            'name' => $newUserData['name'],
            'surname' => $newUserData['surname'],
            'email' => $newUserData['email'],
        ];
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
        $this->assertDatabaseHas('users', $data);

        $response = $this->postJson(route('v1.auth'), ['email' => $newUserData['email'], 'password' => 'secret']);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'surname', 'email', 'created_at', 'updated_at', 'token']);
    }

    public function testUpdateFailAccessDeniedByUserId()
    {
        $otherUser = factory(User::class)->create();

        $newUserData = factory(User::class)->make()->toArray();
        $newUserData['current_password'] = 'admin';
        $response = $this->putJson(route('v1.users.update', $otherUser->id), $newUserData, $this->getJWTHeader());


        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => $newUserData['email']]);
    }

    public function testUpdateFailAccessDeniedByWrongPassword()
    {
        $newUserData = factory(User::class)->make()->toArray();
        $newUserData['current_password'] = 'wrong_password';
        $response = $this->putJson(route('v1.users.update', 1), $newUserData, $this->getJWTHeader());


        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => $newUserData['email']]);
    }
}
