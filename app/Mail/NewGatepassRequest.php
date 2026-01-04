<?php

namespace App\Mail;

use App\Models\Gatepass;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewGatepassRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $gatepass;
    public $recipient;

    public function __construct(Gatepass $gatepass, User $recipient)
    {
        $this->gatepass = $gatepass;
        $this->recipient = $recipient;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Gatepass Request - ' . $this->gatepass->student->user->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-gatepass-request',
            with: [
                'gatepass' => $this->gatepass,
                'recipient' => $this->recipient,
                'student' => $this->gatepass->student,
                'department' => $this->gatepass->student->department,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
