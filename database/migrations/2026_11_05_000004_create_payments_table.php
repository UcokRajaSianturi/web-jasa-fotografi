<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('transaction_code')->unique();
            $table->string('payment_gateway')->default('midtrans_simulation'); // 'midtrans_simulation', 'midtrans_snap'
            $table->string('payment_method'); // 'qris', 'bca_va', 'mandiri_va', 'bni_va', 'credit_card'
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('unpaid'); // 'unpaid', 'paid', 'failed', 'expired'
            $table->string('snap_token')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
