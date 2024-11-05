<?php

use App\Models\FeedSubscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feed_subscription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FeedSubscription::class)->constrained();
            $table->string('title');
            $table->string('guid');
            $table->string('link');
            $table->text('description')->nullable();
            $table->dateTime('pub_date')->nullable();
            $table->unique(['feed_subscription_id', 'guid']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_subscription_items');
    }
};
