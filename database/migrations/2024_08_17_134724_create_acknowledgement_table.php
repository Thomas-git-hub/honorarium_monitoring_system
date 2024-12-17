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
        Schema::create('acknowledgement', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->nullable();

            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('from_office_id')->nullable();
            $table->foreign('office_id')->references('id')->on('office');
            $table->foreign('from_office_id')->references('id')->on('office');

            $table->unsignedBigInteger('received_by')->nullable();
            $table->unsignedBigInteger('from_user')->nullable();
            $table->foreign('received_by')->references('id')->on('users');
            $table->foreign('from_user')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acknowledgement');
    }
};
