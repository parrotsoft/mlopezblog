<?php

namespace Tests\Feature\Jobs;

use App\Jobs\PostImportJob;
use App\Mail\ImportMail;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostImportJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_import_post_from_file(): void
    {
        Storage::fake();
        Mail::fake();
        Storage::put('import-file.csv', file_get_contents(__DIR__.'/../../Support/import-file.csv'));

        $category = Category::factory()->create([
            'name' => 'Category from csv file.',
        ]);

        $user = User::factory()->create();

        (new PostImportJob('import-file.csv', $user))->handle();

        Mail::assertSent(ImportMail::class);

        $this->assertDatabaseCount('posts', 10);
        $this->assertDatabaseHas('posts', [
            'id' => 3,
            'title' => 'Title from csv file.',
            'body' => 'Body from csv file.',
            'price' => 50000,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_it_import_post_from_file_failed(): void
    {
        Storage::fake();
        $user = User::factory()->create();

        (new PostImportJob('import-file.csv', $user))->handle();

        $this->assertDatabaseCount('posts', 0);
    }
}
