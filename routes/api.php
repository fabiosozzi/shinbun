<?php

use App\Actions\Feed\GetAllFeeds;
use App\Actions\Feed\GetAllNewsFromFeed;
use App\Actions\Feed\GetSpecificNews;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->name('api.')->group(function () {
    /*Route::name('feeds.')->prefix('feeds')->group(function () {
        Route::get('/', GetAllFeeds::class)->name('index');
    });*/

    /*Route::name('news.')->prefix('news')->group(function () {
        Route::get('/{feed}', GetAllNewsFromFeed::class)->name('index');
        Route::get('/{feed}/{feed_item}', GetSpecificNews::class)->name('show');
    });*/
});
