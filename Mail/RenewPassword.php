<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $uniqueHash;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $uniqueHash)
    {
        $this->user = $user;
        $this->uniqueHash = $uniqueHash;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Renew password')->view('mail.renewPassword');
    }
}
