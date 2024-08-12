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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('honorarium_id');
            $table->string('office');
            $table->unsignedBigInteger('employee_id');
            $table->string('month');
            $table->string('sem');
            $table->integer('year');
            $table->string('date_of_trans');
            $table->string('status');
            $table->string('created_by');
            $table->boolean('is_complete')->default(0);
            $table->timestamps();

            $table->foreign('honorarium_id')->references('id')->on('honorarium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
