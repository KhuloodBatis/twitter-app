<?php

namespace App\Notifications\Tweets;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Bus\Queueable;
use App\Http\Resources\User\UserResource;
use Illuminate\Notifications\Notification;
use App\Http\Resources\Tweet\TweetResource;
use App\Notifications\DatabaseNotificationChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TweetLiked extends Notification
{
    use Queueable;
    /**
     *
     */
    protected $user;


    protected $tweet;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Tweet $tweet)
    {
        $this->user = $user;
        $this->tweet = $tweet;
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
            'tweet' => new TweetResource($this->tweet),

        ];
    }
}
