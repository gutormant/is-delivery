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
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
//            $table->string('first_name', 32);
//            $table->string('middle_name', 48);
//            $table->string('last_name', 48);
//            $table->string('email', 48);
//            $table->string('address', 48);
//            $table->string('phone', 20);
            $table->foreignId('user_id')->constrained();
            $table->unsignedSmallInteger('width');
            $table->unsignedSmallInteger('height');
            $table->unsignedSmallInteger('depth');
            $table->unsignedMediumInteger('weight');
            $table->unsignedTinyInteger('service')->default(1);
            $table->enum('status', ['new', 'sent', 'failed', 'retry_send'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
