<?php

namespace App\Mail;

use App\Models\TalentShortlist;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the Isla inbox when a client books interviews from a talent bench
 * link, so the team can confirm the slots with each candidate.
 */
class InterviewRequestBooked extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TalentShortlist $shortlist)
    {
    }

    public function envelope(): Envelope
    {
        $name = trim((string) $this->shortlist->client_name) ?: 'A client';
        $count = count($this->shortlist->interview_schedule ?? $this->shortlist->selections ?? []);
        $scope = $this->shortlist->subRole?->name ?? $this->shortlist->role?->name ?? 'Talent bench';

        $replyTo = [];
        if (filter_var($this->shortlist->client_email, FILTER_VALIDATE_EMAIL)) {
            $replyTo[] = new Address($this->shortlist->client_email, $name);
        }

        return new Envelope(
            subject: sprintf('%d interview%s requested — %s (%s)', $count, $count === 1 ? '' : 's', $name, $scope),
            replyTo: $replyTo,
        );
    }

    public function content(): Content
    {
        // Candidates keyed by id so the schedule rows can name who each slot is for.
        $candidates = $this->shortlist->rankedProfiles()->keyBy('id');

        return new Content(
            view: 'emails.interview-request',
            with: [
                'shortlist'  => $this->shortlist,
                'candidates' => $candidates,
                'schedule'   => $this->shortlist->interview_schedule ?? [],
            ],
        );
    }
}
