<?php
namespace App\Notifications;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BlogCreatedNotification extends Notification
{
    use Queueable;

    protected $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function via($notifiable)
    {
        return ['database']; // We'll use database notifications
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'       => 'blog_notification',
            'message'    => 'New Blog Created ' . $this->blog->name,
            'blog_id'    => $this->blog->id,
            'created_at' => $this->blog->created_at,
            'url'        => route('admin.blog.index'), // Pass the correct URL here
        ];
    }

}
