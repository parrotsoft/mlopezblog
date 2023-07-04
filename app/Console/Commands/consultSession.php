<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class consultSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consult-session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::query()->where('status', '=', 'PENDING')->get();
        foreach ($orders as $order) {
            echo $order->order_id.PHP_EOL;
            $result = Http::post(config('placetopay.url')."/api/session/$order->order_id", [
                'auth' => $this->getAuth(),
            ]);

            if ($result->ok()) {
                $status = $result->json()['status']['status'];
                if ($status == 'APPROVED') {
                    $order->completed();
                } elseif ($status == 'REJECTED') {
                    $order->canceled();
                }
            }
        }
    }

    private function getAuth(): array
    {
        $nonce = Str::random();
        $seed = date('c');

        return [
            'login' => config('placetopay.login'),
            'tranKey' => base64_encode(
                hash(
                    'sha256',
                    $nonce.$seed.config('placetopay.tranKey'),
                    true
                )
            ),
            'nonce' => base64_encode($nonce),
            'seed' => $seed,
        ];
    }
}
