<?php

namespace App\Notifications\Messages;

use App\Http\Resources\Message\MessageResource;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Http\Resources\User\UserResource;
use Illuminate\Notifications\Notification;
use App\Http\Resources\Tweet\TweetResource;
use App\Models\Message;
use App\Notifications\DatabaseNotificationChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessagesNotification extends Notification
{
    use Queueable;
    /**
     *
     */
    protected $user;


    protected $message;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->$message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    //because you user datatbase
    public function via($notifiable)
    {
        return [DatabaseNotificationChannel::class];
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user'  => new UserResource($this->user),
            'messag' => new MessageResource($this->message),

        ];
    }
}
