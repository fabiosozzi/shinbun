<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedSubscriptionItem extends Model
{
    protected $fillable = [
        'feed_id',
        'title',
        'link',
        'description',
        'pub_date',
    ];

    public function feed_subscription()
    {
        return $this->belongsTo(Feed::class);
    }
}
