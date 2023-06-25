<?php

namespace Tests\Feature\Web;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_can_call_index(): void
    {
        Category::factory(10)->create();

        $this->get(route('categories.index'))
            ->assertViewIs('categories.index');
    }

    public function test_can_create_category(): void
    {
        $category = Category::factory()->make();
        $this->post(route('categories.store'), [
            'name' => $category->name,
        ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
        ]);
    }

    public function test_can_show_one_category(): void
    {
        $category = Category::factory()->create();

        $this->get(route('categories.show', $category->id))
            ->assertViewIs('categories.create');
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create();

        $this->put(route('categories.update', $category->id), [
            'name' => 'test',
        ])->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'test',
        ]);
    }

    public function test_can_destroy_category(): void
    {
        $category = Category::factory()->create();

        $this->delete(route('categories.destroy', $category->id))
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', [
            'name' => $category->name,
        ]);
    }

    public function test_can_see_create_form(): void
    {
        $this->get(route('categories.create'))
            ->assertViewIs('categories.create');
    }
}
