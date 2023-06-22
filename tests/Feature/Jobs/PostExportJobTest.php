<?php

namespace Tests\Feature\Jobs;

use App\Jobs\PostExportJob;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostExportJobTest extends TestCase
{
    public function test_it_generate_export_file_ok(): void
    {
        Storage::fake(config()->get('filesystem.default'));
        (new PostExportJob())->handle();
        Storage::disk(config()->get('filesystem.default'))->assertExists('exports/my-file-test.csv');
    }
}
