<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds 2C2P-specific tracking fields to the payments table:
     * - invoice_no: The unique invoice number sent to 2C2P (DDC-YYYYMMDD-HEXID format)
     * - twoc2p_transaction_code: UUID nonce for Anti-Replay Protection
     * - twoc2p_status: Raw status code returned by 2C2P (e.g. '000' = success)
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('invoice_no', 30)->nullable()->unique()->after('transaction_id')
                  ->comment('Anti-Gravity unique invoice sent to 2C2P: DDC-YYYYMMDD-HEXID');
            $table->string('twoc2p_transaction_code', 36)->nullable()->unique()->after('invoice_no')
                  ->comment('UUID nonce for 2C2P Anti-Replay Protection');
            $table->string('twoc2p_status', 10)->nullable()->after('twoc2p_transaction_code')
                  ->comment('Raw 2C2P response code: 000=success, 001=pending, etc.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['invoice_no', 'twoc2p_transaction_code', 'twoc2p_status']);
        });
    }
};
