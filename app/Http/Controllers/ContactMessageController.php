<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource for the admin panel.
     * This would typically be a protected route.
     */
    public function index()
    {
        return ContactMessageResource::collection(ContactMessage::all());
        // return ContactMessageResource::collection(ContactMessage::latest()->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     * This is the public endpoint for the contact form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return response()->json(['message' => 'Your message has been sent successfully!']);
    }

    /**
     * Display the specified resource.
     * This would typically be a protected route.
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark the message as read when an admin views it for the first time
        if ($contactMessage->read_at === null) {
            $contactMessage->update(['read_at' => now()]);
        }

        return new ContactMessageResource($contactMessage);
    }

    /**
     * Update the specified resource in storage.
     * Can be used to manually mark a message as read or unread.
     */
    public function update(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $contactMessage->update([
            'read_at' => $validated['is_read'] ? now() : null,
        ]);

        return new ContactMessageResource($contactMessage);
    }

    /**
     * Remove the specified resource from storage.
     * This would typically be a protected route.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
