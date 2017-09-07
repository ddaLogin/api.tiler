<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexSuccess()
    {
        $categories = factory(Category::class, 5)->create();

        $response = $this->get(route('v1.categories.index'));

        $response->assertStatus(200);
        $response->assertJson($categories->toArray());
    }
}
