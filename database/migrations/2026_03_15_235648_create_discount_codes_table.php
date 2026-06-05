<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('discount_codes', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Il codice (es. SCONTO2026)
        $table->decimal('amount', 8, 2);  // Il valore da scontare (es. 5.00)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
