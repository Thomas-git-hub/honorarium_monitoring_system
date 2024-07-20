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
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('month');
            $table->string('sem');
            $table->integer('year');
            $table->string('date_of_trans');
            $table->string('status');
            $table->string('create_by');
            $table->timestamps();

            $table->foreign('honorarium_id')->references('id')->on('honorarium');
            $table->foreign('office_id')->references('id')->on('office');
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
