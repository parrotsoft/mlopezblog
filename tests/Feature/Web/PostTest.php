<?php

namespace Tests\Feature\Web;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_can_call_index(): void
    {
        Post::factory(10)->create();

        $this->get(route('posts.index'))
            ->assertViewIs('posts.index');
    }

    public function test_can_store(): void
    {
        $post = Post::factory()->make();

        $this->post(route('posts.store'), [
            'category_id' => $post->category_id,
            'title' => $post->title,
            'body' => $post->body,
        ])->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'category_id' => $post->category_id,
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    public function test_can_show(): void
    {
        $post = Post::factory()->create();

        $this->get(route('posts.show', $post->id))
            ->assertViewIs('posts.create');

    }

    public function test_can_update(): void
    {
        $post = Post::factory()->create();

        $this->put(route('posts.update', $post->id), [
            'title' => 'test',
            'body' => 'test',
        ])->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'test',
            'body' => 'test',
        ]);
    }

    public function test_can_destroy(): void
    {
        $post = Post::factory()->create();

        $this->delete(route('posts.destroy', $post->id))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    public function test_can_see_form_create(): void
    {
        $this->get(route('posts.create'))
            ->assertViewIs('posts.create');
    }
}
