<?php
namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductCreatedNotification extends Notification
{
    use Queueable;

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['database']; // We'll use database notifications
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'       => 'product_notification',
            'message'    => 'New Product Created ' . $this->product->name,
            'product_id' => $this->product->id,
            'created_at' => $this->product->created_at,
            'url'        => route('admin.product.index'), // Pass the correct URL here
        ];
    }

}
