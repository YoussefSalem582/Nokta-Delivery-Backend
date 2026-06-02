<?php

$migrationsDir = __DIR__ . '/database/migrations';
$files = glob($migrationsDir . '/*_create_*.php');

$schemas = [
    'rider_profiles' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('user_id')->constrained()->cascadeOnDelete();\n            \$table->timestamps();\n            \$table->softDeletes();",
    
    'driver_profiles' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('user_id')->constrained()->cascadeOnDelete();\n            \$table->string('availability')->default('OFFLINE');\n            \$table->decimal('rating', 3, 2)->default(5.00);\n            \$table->boolean('is_registered')->default(false);\n            \$table->timestamp('terms_accepted_at')->nullable();\n            \$table->timestamp('registered_at')->nullable();\n            \$table->timestamps();\n            \$table->softDeletes();",
    
    'courier_profiles' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('user_id')->constrained()->cascadeOnDelete();\n            \$table->string('availability')->default('OFFLINE');\n            \$table->decimal('rating', 3, 2)->default(5.00);\n            \$table->boolean('is_registered')->default(false);\n            \$table->timestamp('terms_accepted_at')->nullable();\n            \$table->timestamp('registered_at')->nullable();\n            \$table->timestamps();\n            \$table->softDeletes();",
    
    'vehicles' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('driver_profile_id')->constrained()->cascadeOnDelete();\n            \$table->string('vehicle_type');\n            \$table->string('make_model');\n            \$table->string('license_plate');\n            \$table->string('color')->nullable();\n            \$table->timestamps();\n            \$table->softDeletes();",
    
    'rides' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('rider_id')->constrained('users')->cascadeOnDelete();\n            \$table->foreignUuid('driver_id')->nullable()->constrained('users')->nullOnDelete();\n            \$table->string('pickup_address');\n            \$table->string('dropoff_address');\n            \$table->decimal('pickup_lat', 10, 7);\n            \$table->decimal('pickup_lng', 10, 7);\n            \$table->decimal('dropoff_lat', 10, 7);\n            \$table->decimal('dropoff_lng', 10, 7);\n            \$table->string('status')->default('REQUESTED');\n            \$table->decimal('fare', 10, 2);\n            \$table->decimal('distance_km', 8, 2)->nullable();\n            \$table->integer('eta_minutes')->nullable();\n            \$table->string('payment_method_key')->nullable();\n            \$table->string('ride_tier_key')->nullable();\n            \$table->decimal('driver_lat', 10, 7)->nullable();\n            \$table->decimal('driver_lng', 10, 7)->nullable();\n            \$table->string('idempotency_key')->nullable()->unique();\n            \$table->timestamps();\n            \$table->softDeletes();",
    
    'deliveries' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('customer_id')->constrained('users')->cascadeOnDelete();\n            \$table->foreignUuid('courier_id')->nullable()->constrained('users')->nullOnDelete();\n            \$table->string('pickup_address');\n            \$table->string('dropoff_address');\n            \$table->decimal('pickup_lat', 10, 7);\n            \$table->decimal('pickup_lng', 10, 7);\n            \$table->decimal('dropoff_lat', 10, 7);\n            \$table->decimal('dropoff_lng', 10, 7);\n            \$table->string('status')->default('REQUESTED');\n            \$table->decimal('fee', 10, 2)->nullable();\n            \$table->text('package_notes')->nullable();\n            \$table->string('idempotency_key')->nullable()->unique();\n            \$table->timestamps();\n            \$table->softDeletes();",
    
    'ride_locations' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('ride_id')->constrained()->cascadeOnDelete();\n            \$table->decimal('lat', 10, 7);\n            \$table->decimal('lng', 10, 7);\n            \$table->decimal('heading', 5, 2)->nullable();\n            \$table->decimal('speed', 6, 2)->nullable();\n            \$table->timestamp('recorded_at');\n            \$table->index(['ride_id', 'recorded_at']);",
    
    'delivery_locations' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('delivery_id')->constrained()->cascadeOnDelete();\n            \$table->decimal('lat', 10, 7);\n            \$table->decimal('lng', 10, 7);\n            \$table->decimal('heading', 5, 2)->nullable();\n            \$table->timestamp('recorded_at');\n            \$table->index(['delivery_id', 'recorded_at']);",
    
    'ride_events' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('ride_id')->constrained()->cascadeOnDelete();\n            \$table->string('status');\n            \$table->json('metadata')->nullable();\n            \$table->timestamp('created_at')->useCurrent();\n            \$table->index(['ride_id', 'created_at']);",
    
    'delivery_events' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('delivery_id')->constrained()->cascadeOnDelete();\n            \$table->string('status');\n            \$table->json('metadata')->nullable();\n            \$table->timestamp('created_at')->useCurrent();\n            \$table->index(['delivery_id', 'created_at']);",
    
    'device_tokens' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('user_id')->constrained()->cascadeOnDelete();\n            \$table->string('token')->unique();\n            \$table->string('platform');\n            \$table->timestamps();",
    
    'sync_requests' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('user_id')->constrained()->cascadeOnDelete();\n            \$table->string('client_action_id');\n            \$table->string('action_type');\n            \$table->json('payload');\n            \$table->string('status')->default('PENDING');\n            \$table->json('response')->nullable();\n            \$table->timestamp('processed_at')->nullable();\n            \$table->timestamps();\n            \$table->unique(['user_id', 'client_action_id']);\n            \$table->index(['user_id', 'status']);",
    
    'audit_logs' => "\$table->uuid('id')->primary();\n            \$table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();\n            \$table->string('action');\n            \$table->string('entity_type');\n            \$table->string('entity_id')->nullable();\n            \$table->json('metadata')->nullable();\n            \$table->string('ip_address')->nullable();\n            \$table->timestamp('created_at')->useCurrent();\n            \$table->index(['entity_type', 'entity_id']);",
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    foreach ($schemas as $table => $schemaFields) {
        if (strpos($file, 'create_' . $table . '_table') !== false) {
            // Find the Schema::create block
            $pattern = "/Schema::create\('$table', function \(Blueprint \\\$table\) \{(.*?)\}\);/s";
            $replacement = "Schema::create('$table', function (Blueprint \$table) {\n            $schemaFields\n        });";
            $content = preg_replace($pattern, $replacement, $content);
            file_put_contents($file, $content);
            echo "Updated migration for table: $table\n";
        }
    }
}
