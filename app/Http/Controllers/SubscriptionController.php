<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|string|in:basic_monthly,pro_monthly',
            'payment_method' => 'required|string',
        ]);

        $user = $request->user();

        try {
            $user->newSubscription('default', $request->plan)
                 ->create($request->payment_method);
        } catch (IncompletePayment $exception) {
            return response()->json([
                'message' => 'Payment requires additional verification.',
                'payment_intent' => $exception->payment->id
            ], 402);
        }

        return response()->json(['message' => 'Subscription successful']);
    }

    public function cancel(Request $request)
    {
        $user = $request->user();
        $user->subscription('default')->cancel();
        return response()->json(['message' => 'Subscription canceled']);
    }

    public function status(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'subscribed' => $user->subscribed('default'),
            'on_trial' => $user->onTrial('default'),
            'canceled' => $user->subscription('default')?->canceled(),
        ]);
    }
}
