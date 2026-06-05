<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('group_code')->unique();
            $table->decimal('total_amount', 8, 2)->default(0);
            $table->string('payment_method');
            $table->boolean('is_sports_association')->default(false);
            $table->string('association_name')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
