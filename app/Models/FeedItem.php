<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedItem extends Model
{
    protected $fillable = [
        'feed_id',
        'title',
        'link',
        'description',
        'pub_date',
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
