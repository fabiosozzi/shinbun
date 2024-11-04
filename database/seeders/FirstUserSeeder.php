<?php

namespace Database\Seeders;

use App\Actions\FeedSubscription\AddNewFeedSubscription;
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

        $rss_list = [
            'https://www.repubblica.it/rss/scienze/rss2.0.xml',
            //'http://rss.art19.com/the-daily',
            'https://multiplayer.it/feed/rss/news/',
        ];

        foreach ($rss_list as $rss) {
            $feedDTO = new FeedDTO([
                'link' => $rss,
            ]);

            AddNewFeedSubscription::run($feedDTO, $user->id);
        }
    }
}
