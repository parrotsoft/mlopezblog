<?php

namespace App\Jobs;

use App\Mail\ImportMail;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostImportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const HEADERS = [
        'id' => 0,
        'title' => 1,
        'body' => 2,
        'price' => 3,
        'category' => 4,
    ];

    public function __construct(private readonly string $pathFile, private readonly User $user)
    {
    }

    public function handle(): void
    {
        try {
            if (($file = fopen(Storage::path($this->pathFile), 'r')) !== false) {
                fgetcsv($file);

                while (($row = fgetcsv($file)) !== false) {
                    $this->processRow($row);
                }

                fclose($file);

                Mail::to($this->user)
                    ->send((new ImportMail('Import post successful'))->subject('Import posts successful'));
            }
        } catch (\Exception $exception) {

            Mail::to($this->user)->send((new ImportMail('Failed import posts'))->subject('Failed import posts'));

            logger()->warning('error when import file', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
            ]);
        }
    }

    private function processRow(array $row): void
    {
        Post::query()->updateOrCreate([
            'id' => $row[self::HEADERS['id']],
        ], [
            'id' => $row[self::HEADERS['id']],
            'title' => $row[self::HEADERS['title']],
            'body' => $row[self::HEADERS['body']],
            'price' => $row[self::HEADERS['price']],
            'category_id' => $this->getCategoryId($row[self::HEADERS['category']]),
            'user_id' => $this->user->id,
        ]);
    }

    private function getCategoryId(string $categoryName): int
    {
        $category = Category::query()->firstOrCreate([
            'name' => $categoryName,
        ], [
            'name' => $categoryName,
        ]);

        return $category->id;
    }
}
