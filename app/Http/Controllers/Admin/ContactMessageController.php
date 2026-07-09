<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ContactMessage::class, 'contact_message');
    }

    public function index()
    {
        $messages = ContactMessage::orderByDesc('created_at')->paginate(20);

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->read_at === null) {
            $contactMessage->forceFill(['read_at' => now()])->save();
        }

        return view('admin.contact-messages.show', ['message' => $contactMessage]);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('status', 'Mensaje eliminado.');
    }
}
