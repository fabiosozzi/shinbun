<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
{
    protected $fillable = [
        'title',
        'link',
        'description',
        'language',
        'status',
    ];

    public function feed_items(): HasMany
    {
        return $this->hasMany(FeedItem::class);
    }
}
