<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    /**
     * Display the about us page.
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Process the contact form.
     */
    public function contactSubmit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would typically send an email
        // This is just a placeholder for now

        // Mail::to('contact@selectyourgame.com')->send(new ContactFormMail($validated));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    /**
     * Display the FAQ page.
     */
    public function faq(): View
    {
        return view('pages.faq');
    }

    /**
     * Display the privacy policy.
     */
    public function privacy(): View
    {
        return view('pages.privacy');
    }

    /**
     * Display the terms of service.
     */
    public function terms(): View
    {
        return view('pages.terms');
    }

    /**
     * Display the platforms page.
     */
    public function platforms(): View
    {
        $platforms = Platform::query()
            ->where('is_active', true)
            ->get();

        return view('pages.platforms', compact('platforms'));
    }
}
