<?php

namespace App\Listeners\FeedSubscription;

use App\Actions\FeedSubscription\SyncFeedSubscriptiontoFeed;
use App\Events\Feed\FeedSuccessfullyReloaded;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncFeedSubscriptionwithFeed implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FeedSuccessfullyReloaded $event): void
    {
        $event->feed->feed_subscriptions->each(function ($feed_subscription) use ($event) {
            SyncFeedSubscriptiontoFeed::run($event->feed, $feed_subscription);
        });
    }
}
