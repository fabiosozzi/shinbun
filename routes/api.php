<?php

use App\Actions\Feed\GetAllFeeds;
use App\Actions\Feed\GetSpecificNews;
use Illuminate\Support\Facades\Route;
use App\Actions\Feed\GetAllNewsFromFeed;
use App\Actions\FeedSubscription\GetAllFeedSubscriptions;
use App\Actions\FeedSubscription\GetSpecificFeedSubscriptionItem;
use App\Actions\FeedSubscription\GetAllItemsFromFeedSubscriptions;

Route::middleware(['auth:sanctum'])->name('api.')->group(function () {
    Route::name('feeds.')->prefix('feeds')->group(function () {
        Route::get('/', GetAllFeedSubscriptions::class)->name('index');
    });

    Route::name('news.')->prefix('news')->group(function () {
        Route::get('/{feed_subscription_id}', GetAllItemsFromFeedSubscriptions::class)->name('index');
        Route::get('/{feed}/{feed_subscription_item_id}', GetSpecificFeedSubscriptionItem::class)->name('show');
    });
});
