<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
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

    public int $tries = 2;

    public int $maxExceptions = 1;

    public function __construct(protected User $user)
    {
    }

    public function handle($name = null): void
    {
        $headers = [
            'id',
            'title',
            'body',
            'price',
            'category',
        ];

        $fileName = sprintf('exports/%s.csv', $name ?? Str::uuid()->serialize());
        $this->createFile($fileName);
        $file = $this->openFile($fileName);
        fputcsv($file, $headers);

        Post::with('category')->where('user_id', $this->user->id)->chunk(5, function ($posts) use ($file) {
            /** @var Post $post */
            foreach ($posts as $post) {
                fputcsv($file, [
                    'id' => $post->id,
                    'title' => $post->title,
                    'body' => $post->body,
                    'price' => $post->price,
                    'category' => $post->category->name,
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
