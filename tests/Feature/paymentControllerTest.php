<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class paymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_pay_a_post(): void
    {
        $this->actingAs(User::factory()->create());
        $post = Post::factory()->create();
        $mockResponse =[
            'status' => [
                'status' => 'OK',
                'reason' => 'PC',
                'message' => 'La petición se ha procesado correctamente',
                'date' => '2021-11-30T15:08:27-05:00'
            ],
            'requestId' => 1,
            "processUrl" => "https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a"
        ];

        Http::fake([config('placetopay.url').'/*' => Http::response($mockResponse )]);

        $this->postJson(route('payments.processPayment'), [
            'payment_type' => 'PlaceToPay',
            'price' => $post->price,
            'post_id' => $post->getKey()
        ])->assertRedirect('https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a');
    }
}
