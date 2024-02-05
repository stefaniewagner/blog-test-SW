<?php

use Illuminate\Foundation\Inspiring;
use App\Models\Post;
use Monolog\DateTimeImmutable;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('publishpost', function() {
    $date = new DateTimeImmutable('now'); 
    $post = Post::create(
        [
            'title' => $date->format('\Z\u\s\a\m\m\e\n\f\a\s\s\u\n\g: m.Y'),
            'body' => 'Inhalt',
            'user_id' => 1,
            'category_id' => 1,
            'is_published' => 1,
            'created_at' => $date,
        ]
    );
    $this->info('Post created');
})->describe('Monthly summary post');