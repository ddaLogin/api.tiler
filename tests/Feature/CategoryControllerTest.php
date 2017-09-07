<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexSuccess()
    {
        $categories = factory(Category::class, 5)->create();

        $response = $this->get(route('v1.categories.index'));

        $response->assertStatus(200);
        $response->assertJson($categories->toArray());
    }
}
