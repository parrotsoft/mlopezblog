<?php

namespace Tests\Feature\Web\PostExportController;

use App\Jobs\PostExportJob;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostExportsControllerTest extends TestCase
{
    /** @test */
    public function it_validate_route_status_ok(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('posts.export'))
            ->assertRedirect();
    }

    /** @test */
    public function it_should_enqueue_post_export_job(): void
    {
        Queue::fake();
        $this->actingAs(User::factory()->create())
            ->get(route('posts.export'))
            ->assertRedirect();

        Queue::assertPushed(PostExportJob::class);
    }
}
