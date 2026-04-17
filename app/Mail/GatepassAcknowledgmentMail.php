<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Gatepass;
use App\Models\User;

class GatepassAcknowledgmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $gatepass;
    public $actor;
    public $action;
    public $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct(Gatepass $gatepass, User $actor, string $action, User $recipient = null)
    {
        $this->gatepass = $gatepass;
        $this->actor = $actor;
        $this->action = $action; // 'approved', 'rejected', 'submitted'
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->action) {
            'submitted' => 'New Gatepass Request Submitted',
            'approved' => 'Gatepass Approved',
            'rejected' => 'Gatepass Rejected',
            'final_approved' => 'Gatepass Fully Approved',
            default => 'Gatepass Update'
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.gatepass.acknowledgment',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
