<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('lawyer_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('lawyer_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('users');
            $table->timestamp("booking_start_date")->nullable();
            ;
            $table->timestamp("booking_end_date")->nullable();
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
