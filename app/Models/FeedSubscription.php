<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedSubscription extends Model
{
    protected $fillable = [
        'title',
        'link',
        'description',
        'language',
        'user_id',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function feed_subscription_items(): HasMany
    {
        return $this->hasMany(FeedSubscriptionItem::class);
    }
}
