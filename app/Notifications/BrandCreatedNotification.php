<?php
namespace App\Notifications;

use App\Models\Brand;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BrandCreatedNotification extends Notification
{
    use Queueable;

    protected $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function via($notifiable)
    {
        return ['database']; // We'll use database notifications
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'       => 'brand_notification',
            'message'    => 'New Brand Created ' . $this->brand->name,
            'brand_id'   => $this->brand->id,
            'created_at' => $this->brand->created_at,
            'url'        => route('admin.brands.index'), // Pass the correct URL here
        ];
    }

}
