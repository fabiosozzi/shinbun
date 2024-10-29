<?php

namespace App\Http\Controllers;

use App\Actions\Feed\GetAllFeeds;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $db_feeds = GetAllFeeds::run($request->user()->id);

        return Inertia::render('Home', [
            'title' => 'Home',
            'db_feeds' => $db_feeds,
        ]);
    }
}
