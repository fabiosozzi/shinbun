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
        $rss_list = [
            'https://multiplayer.it/feed/rss/news/',
            'https://www.repubblica.it/rss/scienze/rss2.0.xml',
            'http://rss.art19.com/the-daily',
            //'https://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml',
            //'https://chaski.huffpost.com/us/auto/vertical/front-page',
            //'https://www.politico.com/rss/politicopicks.xml',
        ];

        $user = User::factory()->create([
            'name' => 'Fabio Sozzi',
            'email' => 'fabio.sozzi@gmail.com',
            'password' => bcrypt('password'),
        ]);

        foreach ($rss_list as $rss) {
            $feedDTO = new FeedDTO([
                'link' => $rss,
            ]);

            AddNewFeed::run($feedDTO, $user->id);
        }
    }
}
