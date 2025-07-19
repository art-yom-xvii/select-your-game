<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    /**
     * Display newsletter subscribers.
     */
    public function index(): View
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.newsletter-subscribers', compact('subscribers'));
    }

    /**
     * Subscribe to newsletter.
     */
    public function subscribe(Request $request): JsonResponse|RedirectResponse
    {
        // Validate the email
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $validated['email'];

        // Check if email already exists
        $existingSubscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($existingSubscriber) {
            if ($existingSubscriber->is_active) {
                $message = 'This email is already subscribed to our newsletter!';
                $type = 'warning';
            } else {
                // Reactivate the subscription
                $existingSubscriber->update(['is_active' => true]);
                $message = 'Welcome back! Your newsletter subscription has been reactivated.';
                $type = 'success';
            }
        } else {
            // Create new subscription
            NewsletterSubscriber::create([
                'email' => $email,
                'is_active' => true,
            ]);
            $message = 'Thank you for subscribing to our newsletter!';
            $type = 'success';
        }

        // Return response based on request type
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'type' => $type,
            ]);
        }

        return back()->with($type, $message);
    }
}
