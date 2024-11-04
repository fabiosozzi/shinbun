<?php

namespace App\Console\Commands;

use App\Actions\Feed\SyncFeed;
use App\Models\Feed;
use Illuminate\Console\Command;

class SyncAllFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shinbun:sync-all-feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all feeds';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Syncing all feeds...');
        $feeds = Feed::has('feed_subscriptions')->get();
        $feeds->chunk(10)->each(function ($feeds) {
            $feeds->each(function ($feed) {
                $this->info("Syncing feed: {$feed->title}");
                SyncFeed::run($feed);
            });
        });
    }
}
