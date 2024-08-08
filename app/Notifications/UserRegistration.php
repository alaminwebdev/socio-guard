<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class UserRegistration extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable){
        return [
            'user_id'       => $this->user->id,
            'user_name'     => $this->user->name,
            'user_email'    => $this->user->email,
            'user_type'     => $this->user->usertype
        ];
    }

    /*public function toArray($notifiable){
        return [
            'user_id'       => $this->user->id,
            'user_name'     => $this->user->name,
            'user_email'    => $this->user->email,
            'user_type'     => $this->user->usertype
        ];
    }*/
}
