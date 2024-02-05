<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCreatedNotification;
use App\User;
use Tests\TestCase;
use App\Models\Post;


class PostCreatedNotificationTest extends TestCase
{
    /** @test */
    use RefreshDatabase;
    public function notification_sent()
    {
        $admin = User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.net',
            'password' => bcrypt('password'),
            'is_admin' => true
        ]);


        Notification::fake();


        $post = Post::create(
            [
                'title'        => 'Title',
                'body'         => 'Inhalt',
                'user_id'      => 1,
                'category_id'  => 1,
                'is_published' => 1,
                'created_at'   => '10.10.2022',
            ]
        );


        $admin->notify(new PostCreatedNotification($post));
        Notification::assertSentTo($admin, PostCreatedNotification::class, function ($notification, $channels, $notifiable) use ($post)
            {
                $this->assertEquals('Neuer Post', $notification->toMail($notifiable)->subject);
                $this->assertEquals(url('/posts/' . $post->post_id), $notification->toMail($notifiable)->actionUrl);
                return true;
            }
        );
    }
}
