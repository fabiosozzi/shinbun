<?php

namespace App\Http\Controllers;

use App\Actions\FeedSubscription\GetAllFeedSubscriptions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // TODO: it would be better to avoid this call and fetch the data only with the API
        $db_feeds = GetAllFeedSubscriptions::run($request->user()->id);

        return Inertia::render('Home', [
            'title' => 'Home',
            'db_feeds' => $db_feeds,
        ]);
    }
}
