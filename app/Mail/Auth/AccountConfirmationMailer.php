<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountConfirmationMailer extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User $user */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = url("/register/confirm-email/{$this->user->email}/token/{$this->user->verify_token}");
        return $this
            ->subject('Account confirmation')
            ->view('emails.auth.account_confirm', [
                'user' => $this->user,
                'user_confirm_link' => $link,
            ]);
    }
}
