<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiscoveryCallEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $enquiry)
    {
    }

    public function envelope(): Envelope
    {
        $name = trim((string) $this->enquiry->full_name) ?: 'New enquiry';
        $isCall = str_contains((string) $this->enquiry->message, 'Preferred call time:');
        $subject = ($isCall ? 'New discovery call request — ' : 'New website enquiry — ') . $name;

        $replyTo = [];
        if (filter_var($this->enquiry->email, FILTER_VALIDATE_EMAIL)) {
            $replyTo[] = new Address($this->enquiry->email, $name);
        }

        return new Envelope(subject: $subject, replyTo: $replyTo);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.discovery-call');
    }
}
