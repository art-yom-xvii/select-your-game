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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', [
                'pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'
            ])->default('pending');

            // Customer information
            $table->string('customer_email');
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();

            // Address information
            $table->text('billing_address');
            $table->text('shipping_address');

            // Payment details
            $table->string('payment_method');
            $table->string('payment_id')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Order totals
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Shipping details
            $table->string('shipping_method')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable();

            // Notes and metadata
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
