<?php

namespace Tests\Feature\Jobs;

use App\Jobs\PostExportJob;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostExportJobTest extends TestCase
{
    public function test_it_generate_export_file_ok(): void
    {
        Storage::fake(config()->get('filesystem.default'));
        (new PostExportJob())->handle(name: 'my-file-test');
        Storage::disk(config()->get('filesystem.default'))->assertExists('exports/my-file-test.csv');
    }
}
