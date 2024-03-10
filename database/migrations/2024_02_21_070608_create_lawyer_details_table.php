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
        Schema::create('lawyer_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('lawyer_card');
            $table->string('bio');
            $table->integer('price');
            $table->boolean('is_verified')->default(false);
            $table->unsignedBigInteger('lawyer_id');
            $table->foreign('lawyer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_details');
    }
};
