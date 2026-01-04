<?php

namespace App\Mail;

use App\Models\Gatepass;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GatepassRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $gatepass;
    public $rejectedBy;
    public $rejectionType;

    public function __construct(Gatepass $gatepass, User $rejectedBy, string $rejectionType)
    {
        $this->gatepass = $gatepass;
        $this->rejectedBy = $rejectedBy;
        $this->rejectionType = $rejectionType;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gatepass Rejected - ' . $this->gatepass->student->user->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.gatepass-rejected',
            with: [
                'gatepass' => $this->gatepass,
                'rejectedBy' => $this->rejectedBy,
                'rejectionType' => $this->rejectionType,
                'student' => $this->gatepass->student,
                'remarks' => $this->getRemarks(),
            ]
        );
    }

    private function getRemarks()
    {
        switch ($this->rejectionType) {
            case 'staff':
                return $this->gatepass->staff_remarks;
            case 'hod':
                return $this->gatepass->hod_remarks;
            case 'warden':
                return $this->gatepass->warden_remarks;
            default:
                return null;
        }
    }

    public function attachments(): array
    {
        return [];
    }
}
