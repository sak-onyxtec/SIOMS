<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public bool $isActive;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, bool $isActive)
    {
        $this->user = $user;
        $this->isActive = $isActive;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $statusText = $this->isActive ? 'activated' : 'deactivated';

        return $this->subject('Your staff account has been ' . $statusText)
            ->view('emails.staff_status_changed');
    }
}


