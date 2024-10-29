<?php

namespace Database\Seeders;

use App\Actions\Feed\AddNewFeed;
use App\DTOs\FeedDTO;
use App\Models\User;
use Illuminate\Database\Seeder;

class FirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Fabio Sozzi',
            'email' => 'fabio.sozzi@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $feedDTO = new FeedDTO([
            'link' => 'https://multiplayer.it/feed/rss/news/',
        ]);

        AddNewFeed::run($feedDTO, $user->id);

        $feedDTO = new FeedDTO([
            'link' => 'https://www.repubblica.it/rss/scienze/rss2.0.xml',
        ]);

        AddNewFeed::run($feedDTO, $user->id);
    }
}
