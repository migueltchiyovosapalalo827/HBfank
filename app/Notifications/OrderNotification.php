<?php

namespace App\Notifications;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    private Pedido $pedido;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $this->afterCommit();
    }



    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            //
            'pedido' => $this->pedido,
        ];
    }

   public function toBroadcast($notifiable):BroadcastMessage
   {
    return new BroadcastMessage([
        'id' => $this->id,
        'read_at' => null,
        'data' => [
            'pedido' => $this->pedido->load('cliente','productos'),
        ],
    ]);
    }

  public function toArray()
   {
      return [
        'id' => $this->id,
        'read_at' => null,
        'data' => [
            'pedido' => $this->pedido,
        ],
    ];
   }
}
