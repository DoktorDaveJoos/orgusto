<?php

namespace App\Mail;

use App\Restaurant;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInvited extends Mailable
{
    use Queueable, SerializesModels;

    public $restaurant;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Restaurant $restaurant, User $user)
    {
        $this->restaurant = $restaurant;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = route('invitation.show', ['user' => $this->user->id]);

        return $this->markdown('emails.users.invited')
            ->with(['url' => $url]);
    }
}
