<?php

namespace App\Mail;

use App\Models\Gatepass;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class GatepassApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $gatepass;
    public $approvedBy;
    public $approvalType;
    public $pdf;

    public function __construct(Gatepass $gatepass, User $approvedBy, string $approvalType, $pdf)
    {
        $this->gatepass = $gatepass;
        $this->approvedBy = $approvedBy;
        $this->approvalType = $approvalType;
        $this->pdf = $pdf;
    }

    public function envelope(): Envelope
    {
        $status = $this->gatepass->isFinalApproved() ? 'Final Approved' : ucfirst($this->approvalType) . ' Approved';
        return new Envelope(
            subject: "Gatepass {$status} - " . $this->gatepass->student->user->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.gatepass-approved',
            with: [
                'gatepass' => $this->gatepass,
                'approvedBy' => $this->approvedBy,
                'approvalType' => $this->approvalType,
                'student' => $this->gatepass->student,
                'isFinalApproved' => $this->gatepass->isFinalApproved(),
            ]
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        // Attach PDF if final approved
        if ($this->gatepass->isFinalApproved()) {
            $attachments[] = Attachment::fromData(fn() => $this->pdf->output(), "gatepass_{$this->gatepass->id}.pdf")
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }
}
