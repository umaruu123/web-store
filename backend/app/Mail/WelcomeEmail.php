<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Welcome to MochiPals!')
                    ->view('emails.welcome_email')
                    ->with([
                        'username' => $this->user->first_name, // 使用用戶的名字
                    ]);
    }
}