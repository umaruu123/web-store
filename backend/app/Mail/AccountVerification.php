<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AccountVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Verify Your Account')
                    ->view('emails.account_verification')
                    ->with([
                        'verificationUrl' => url("/verify-account/{$this->user->verification_token}"),
                    ]);
    }
}