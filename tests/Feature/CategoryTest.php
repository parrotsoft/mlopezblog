<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_call_index(): void {
        Category::factory(10)->create();

        $response = $this->get(route('categories.index'))
            ->assertOk();

        $this->assertCount(10, $response->json());
    }

    public function test_can_create_category(): void
    {
        $category = Category::factory()->make();
        $this->post(route('categories.store'), [
            'name' => $category->name
        ])->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'name' => $category->name
        ]);
    }

    public function test_can_show_one_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category->id))
            ->assertOk();

        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('id', $category->id)
            ->where('name', $category->name)
            ->etc()
        );
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create();

        $this->put(route('categories.update', $category->id), [
            'name' => 'test'
        ])->assertOk();

        $this->assertDatabaseHas('categories', [
            'name' => 'test'
        ]);
    }

    public function test_can_destroy_category(): void
    {
        $category = Category::factory()->create();

        $this->delete(route('categories.destroy', $category->id))
            ->assertOk();

        $this->assertDatabaseMissing('categories', [
            'name' => $category->name
        ]);
    }
}
