<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use App\Models\Plan;
use Stripe\Customer;
use Stripe\PaymentMethod;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Stripe\Subscription as StripeSubscription;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey("YOUR STRIPE SECRET KEY HERE");
    }

    /**
     * this method will create a customer
     * and subscribe him to a plan
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $plan = Plan::find($request->plan_id);

        try {
            if(!$user->stripe_id) {
                $customer = Customer::create([
                    'email' => $user->email
                ]);

                //save the stripe id of the user
                $user->stripe_id = $customer->id;
                $user->save();
            }
            //retrieve the payment method from the request
            $paymentMethodId = $request->payment_method;

            //attach the payment method the customer
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $user->stripe_id]);

            //set the payment method as the default one for this user
            Customer::update($user->stripe_id,[
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId
                ]
            ]);

            //create the subscription
            $subscription = StripeSubscription::create([
                'customer' => $user->stripe_id,
                'items' => [['price' => $request->price_id]],
                'expand' => ['latest_invoice.payment_intent'],
                'default_payment_method' => $paymentMethodId
            ]);

            //store the subscription in the local database
            $userSubscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'stripe_subscription_id' => $subscription->id,
                'stripe_status' => $subscription->status,
                'stripe_plan_id' => $request->price_id,
                'current_period_start' => $subscription->current_period_start,
                'current_period_end' => $subscription->current_period_end,
            ]);

            //update the user number of hearts
            $user->number_of_hearts = $plan->number_of_hearts;
            $user->save();

            //return the response
            return response()->json([
                'subscription' => $userSubscription,
                'message' => 'Subscription done successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * this method will cancel the subscription
     */
    public function cancel(Request $request)
    {
        $user = $request->user();

        //find the subscription that the user wants to cancel
        //in the local database
        $subscription = Subscription::where([
            'user_id' => $user->id,
            'stripe_subscription_id' => $request->stripe_subscription_id
        ])->first();

        //check if the subscription exists
        if($subscription) {
            $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_subscription_id);
            $stripeSubscription->cancel();

            //delete the subscription from the local database
            $subscription->delete();

            //update the user stripe id
            if(!$user->subscriptions->count()) {
                $user->stripe_id = null;
                $user->save();
            }
            //return the response
            return response()->json([
                'user' => UserResource::make($user),
                'message' => 'Subscription canceled successfully'
            ]);
        }else {
            return response()->json([
                'error' => 'No active subscription found'
            ]);
        }
    }
}
