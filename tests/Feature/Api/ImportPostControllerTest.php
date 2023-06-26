<?php

namespace Tests\Feature\Api;

use App\Jobs\PostImportJob;
use App\Mail\ImportMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ImportPostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_import_posts(): void
    {
        $user = User::factory()->create();

        Storage::fake();
        Bus::fake();
        Mail::fake();
        Sanctum::actingAs($user);

        $response = $this->post(route('api.posts.import'), [
            'file' => new UploadedFile(__DIR__.'/../../Support/import-file.csv', 'testing_file', test: true),
        ]);

        Bus::assertDispatched(PostImportJob::class, function (PostImportJob $job) {
            $job->handle();

            return true;
        });

        Mail::assertSent(ImportMail::class);

        $response
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseCount('posts', 10);
        $this->assertDatabaseHas('posts', [
            'id' => 3,
            'title' => 'Title from csv file.',
            'body' => 'Body from csv file.',
            'price' => 50000,
            'user_id' => $user->id,
        ]);
    }
}
