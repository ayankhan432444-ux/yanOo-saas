<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // 0. View All Plans
    public function index()
    {
        return response()->json([
            'plans' => [
                [
                    'name' => 'Pro Plan',
                    'price' => '$30/month',
                    'stripe_price_id' => 'price_1SojqcJM5TFsmE4QHsYY7PQg', 
                    'features' => ['100 Files Limit', 'Up to 5 Users', 'Priority Support']
                ],
            ]
        ]);
    }

    // 1. Subscribe
   // SubscriptionController.php mein subscribe function ko aise update karein:

public function subscribe(Request $request)
{
    $request->validate([
        'plan_id' => 'required', 
        'payment_method' => 'required' 
    ]);

    $user = $request->user();

    try {
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($request->payment_method);

        // Subscription create karo
        $user->newSubscription('default', $request->plan_id)
             ->create($request->payment_method);

        // ✅ YE HISSA UPDATE KAREIN: Company upgrade logic
        if ($user->company) {
            $user->company->update([
                'status' => 'active',      // Status approved/pending se active kar dein
                'file_limit' => 100,       // Pro Plan ki limit set karein
            ]);
        }

        return response()->json(['message' => 'Subscribed & Upgraded successfully!']);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Payment Failed: ' . $e->getMessage()], 500);
    }
}
public function changePlan(Request $request)

    {

        $request->validate(['plan_id' => 'required']);

       

        $user = $request->user();

       

        // Swap function automatically handles proration (extra paisay adjust karna)

        // check if subscription exists first

        if ($user->subscription('default')) {

             $user->subscription('default')->swap($request->plan_id);

             return response()->json(['message' => 'Plan changed successfully!']);

        }

       

        return response()->json(['message' => 'No active subscription found.'], 404);

    }



    // 3. Cancel Subscription

    public function cancel(Request $request)

    {

        $user = $request->user();



        if ($user->subscription('default')) {

            // Cancel karega par cycle end honay tak access rahega (Grace Period)

            $user->subscription('default')->cancel();

            return response()->json(['message' => 'Subscription cancelled. Access remains until period ends.']);

        }



        return response()->json(['message' => 'No active subscription found.'], 404);

    }



    // 4. Billing History & Invoices

    public function invoices(Request $request)

    {

        $user = $request->user();

       

        // Stripe se invoices fetch karo

        $invoices = $user->invoices()->map(function($invoice) {

            return [

                'date' => $invoice->date()->toFormattedDateString(),

                'total' => $invoice->total(),

                'status' => $invoice->status, // Paid, Open, Void

                'pdf' => $invoice->hosted_invoice_url // Link to PDF

            ];

        });



        return response()->json(['invoices' => $invoices]);

    }
    
}