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
        Schema::table('claims', function (Blueprint $table) {
            if (!Schema::hasColumn('claims', 'estimated_cost')) {
                $table->decimal('estimated_cost', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('claims', 'image_paths')) {
                $table->json('image_paths')->nullable();
            }
            if (!Schema::hasColumn('claims', 'warranty_status')) {
                $table->string('warranty_status')->default('unknown'); // in_warranty, out_of_warranty, unknown
            }
            if (!Schema::hasColumn('claims', 'estimated_days')) {
                $table->integer('estimated_days')->nullable();
            }
            if (!Schema::hasColumn('claims', 'inbound_tracking_number')) {
                $table->string('inbound_tracking_number')->nullable();
            }
            if (!Schema::hasColumn('claims', 'inbound_courier')) {
                $table->string('inbound_courier')->nullable();
            }
            if (!Schema::hasColumn('claims', 'return_tracking_number')) {
                $table->string('return_tracking_number')->nullable();
            }
            if (!Schema::hasColumn('claims', 'return_courier')) {
                $table->string('return_courier')->nullable();
            }
            if (!Schema::hasColumn('claims', 'delivery_method')) {
                $table->string('delivery_method')->default('shipping'); // shipping, dropoff
            }
            if (!Schema::hasColumn('claims', 'customer_confirmed_at')) {
                $table->timestamp('customer_confirmed_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn([
                'warranty_status',
                'estimated_days',
                'inbound_tracking_number',
                'inbound_courier',
                'return_tracking_number',
                'return_courier',
                'delivery_method',
                'customer_confirmed_at',
            ]);
        });
    }
};
