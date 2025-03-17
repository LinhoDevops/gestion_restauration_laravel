<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Order;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle commande reçue')
            ->line("Une nouvelle commande #{$this->order->id} a été passée.")
            ->action('Voir la commande', url("/gestionnaire/orders/{$this->order->id}"))
            ->line('Merci de gérer cette commande rapidement.');
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => "Nouvelle commande #{$this->order->id} reçue de {$this->order->user->name}.",
            'order_id' => $this->order->id,
        ]);
    }
}
