<?php

namespace App\Providers;

use App\Models\CartItem;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(function (Login $event) {
            $sessionId = Session::getId();
            $guestItems = CartItem::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();

            foreach ($guestItems as $guestItem) {
                $existing = CartItem::where('user_id', $event->user->id)
                    ->where('product_id', $guestItem->product_id)
                    ->first();

                if ($existing) {
                    $existing->increment('quantity', $guestItem->quantity);
                    $guestItem->delete();
                } else {
                    $guestItem->update([
                        'user_id' => $event->user->id,
                        'session_id' => null,
                    ]);
                }
            }
        });
    }
}
