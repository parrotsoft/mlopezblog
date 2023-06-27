<?php

namespace Tests\Feature\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);
    }

    public function test_can_call_index(): void
    {
        Post::factory(10)->create();

        $this->getJson(route('api.posts.index'))
            ->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->count('data', 10)->has('data.0', function (AssertableJson $data) {
                    $data->has('id')
                        ->has('title')
                        ->has('body')
                        ->has('price')
                        ->has('category_id')
                        ->has('created_at')
                        ->has('updated_at');
                })->etc();
            });
    }

    public function test_can_store(): void
    {
        /** @var Post $post */
        $post = Post::factory()->make();

        $this->postJson(route('api.posts.store'), [
            'category_id' => $post->category_id,
            'title' => $post->title,
            'body' => $post->body,
        ])->assertCreated()
            ->assertJson(function (AssertableJson $json) use ($post) {
                $json->where('message', 'The post was created successfully')
                    ->has('data', function (AssertableJson $data) use ($post) {
                        $data->has('id')
                            ->where('title', $post->title)
                            ->where('body', $post->body)
                            ->has('price')
                            ->where('category_id', $post->category_id)
                            ->has('created_at')
                            ->has('updated_at');
                    });
            });

        $this->assertDatabaseHas('posts', [
            'category_id' => $post->category_id,
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    public function test_can_show(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $this->getJson(route('api.posts.show', $post->id))
            ->assertOk()
            ->assertJson(function (AssertableJson $json) use ($post) {
                $json->has('data', function (AssertableJson $data) use ($post) {
                    $data->has('id')
                        ->where('title', $post->title)
                        ->where('body', $post->body)
                        ->has('price')
                        ->where('category_id', $post->category_id)
                        ->has('created_at')
                        ->has('updated_at');
                });
            });

    }

    public function test_cannot_update_by_not_owner(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $this->putJson(route('api.posts.update', $post->id), [
            'title' => 'New Title Post',
            'body' => 'New Body Post',
        ])->assertForbidden()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'This action is unauthorized.')->etc();
            });

        $this->assertDatabaseMissing('posts', [
            'title' => 'New Title Post',
            'body' => 'New Body Post',
        ]);
    }

    public function test_can_update(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $this->putJson(route('api.posts.update', $post->id), [
            'title' => 'New Title Post',
            'body' => 'New Body Post',
        ])->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'The post was updated successfully');
            });

        $this->assertDatabaseHas('posts', [
            'title' => 'New Title Post',
            'body' => 'New Body Post',
        ]);
    }

    public function test_cannot_destroy_by_not_owner(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $this->deleteJson(route('api.posts.destroy', $post->id))
            ->assertForbidden()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'This action is unauthorized.')->etc();
            });

        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    public function test_can_destroy(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $this->deleteJson(route('api.posts.destroy', $post->id))
            ->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'The post was deleted successfully');
            });

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }
}
