<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Subscription;

class WebhookController extends \Laravel\Cashier\Http\Controllers\WebhookController
{
    protected function handleCustomerDeleted(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['id'])) {
            $user->subscriptions->each(function (Subscription $subscription) {
                $subscription->skipTrial()->markAsCanceled();
            });

            $user->forceFill([
                'stripe_id' => null,
                'trial_ends_at' => null,
                'pm_type' => null,
                'pm_last_four' => null,
            ])->save();
        }
           Log::info('Customer Was Deleted : '.$user->email);
        return $this->successMethod();
    }
}
