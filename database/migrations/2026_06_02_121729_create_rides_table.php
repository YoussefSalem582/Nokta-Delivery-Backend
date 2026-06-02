<?php

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
        Schema::create('rides', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rider_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('pickup_address');
            $table->string('dropoff_address');
            $table->decimal('pickup_lat', 10, 7);
            $table->decimal('pickup_lng', 10, 7);
            $table->decimal('dropoff_lat', 10, 7);
            $table->decimal('dropoff_lng', 10, 7);
            $table->string('status')->default('REQUESTED');
            $table->decimal('fare', 10, 2);
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->integer('eta_minutes')->nullable();
            $table->string('payment_method_key')->nullable();
            $table->string('ride_tier_key')->nullable();
            $table->decimal('driver_lat', 10, 7)->nullable();
            $table->decimal('driver_lng', 10, 7)->nullable();
            $table->string('idempotency_key')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
