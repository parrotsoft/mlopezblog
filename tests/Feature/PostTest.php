<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_call_index(): void
    {
        Post::factory(10)->create();

        $response = $this->get(route('posts.index'))
            ->assertOk();

        $this->assertCount(10, $response->json());
    }

    public function test_can_store(): void
    {
        $post = Post::factory()->make();

        $this->post(route('posts.store'), [
            'user_id' => $post->user_id,
            'category_id' => $post->category_id,
            'title' => $post->title,
            'body' => $post->body,
        ])->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'user_id' => $post->user_id,
            'category_id' => $post->category_id,
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    public function test_can_show(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.show', $post->id))
            ->assertOk();

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('id', $post->id)
            ->where('user_id', $post->user_id)
            ->where('category_id', $post->category_id)
            ->where('title', $post->title)
            ->where('body', $post->body)
            ->etc()
        );
    }

    public function test_can_update(): void
    {
        $post = Post::factory()->create();

        $this->put(route('posts.update', $post->id), [
            'title' => 'test',
            'body' => 'test',
        ])->assertOk();

        $this->assertDatabaseHas('posts', [
            'title' => 'test',
            'body' => 'test',
        ]);
    }

    public function test_can_destroy(): void
    {
        $post = Post::factory()->create();

        $this->delete(route('posts.destroy', $post->id))
            ->assertOk();

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title,
            'body' => $post->body
        ]);
    }

}
