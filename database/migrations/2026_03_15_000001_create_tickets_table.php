<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('unique_ticket_code')->nullable()->unique();
            $table->decimal('price_paid', 8, 2)->default(26.00);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('route_choice');
            $table->date('dob');
            $table->string('birth_place');
            $table->string('residence_address');
            $table->string('city');
            $table->string('zip_code');
            $table->string('province');
            $table->string('region');
            $table->string('country')->default('Italia');
            $table->string('nationality')->default('IT');
            $table->string('codice_fiscale')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('tshirt_size');
            $table->boolean('shuttle_needed')->default(false);
            $table->boolean('celiac')->default(false);
            $table->string('status')->default('active');
            $table->string('payment_tag');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
