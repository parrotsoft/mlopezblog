<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;

    public $maxExceptions = 1;

    public function handle($name = null): void
    {
        $headers = [
            'title',
            'body',
            'price',
            'category',
            'user',
        ];

        $fileName = sprintf('exports/%s.csv', $name ?? Str::uuid()->serialize());
        $this->createFile($fileName);
        $file = $this->openFile($fileName);
        fputcsv($file, $headers);

        Post::with('category')->chunk(5, function ($posts) use ($file) {
            /** @var Post $post */
            foreach ($posts as $post) {
                    fputcsv($file, [
                        'title' => $post->title,
                        'body' => $post->body,
                        'price' => $post->price,
                        'category' => $post->category->name,
                        'user' => $post->user_id,
                    ]);
                }
        });

        fclose($file);
    }

    private function createFile(string $fileName): void
    {
        Storage::disk(config()->get('filesystem.default'))->put($fileName, '');
    }

    private function openFile(string $fileName)
    {
        return fopen(Storage::disk(config()->get('filesystem.default'))->path($fileName), 'w');
    }
}
