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
            $table->string('batch_id')->nullable();
            $table->unsignedBigInteger('honorarium_id');
            $table->unsignedBigInteger('office');
            $table->unsignedBigInteger('from_office')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->string('month');
            $table->string('sem');
            $table->integer('year');
            $table->string('date_of_trans');
            $table->string('status');
            $table->string('batch_status')->default('No Findings');
            $table->string('created_by');

            // added last nov 05
            $table->decimal('deduction', 20, 2)->nullable();
            $table->string('deduction_remarks')->nullable();

            $table->decimal('net_amount', 20, 2)->nullable();
            $table->boolean('is_complete')->default(0);
            $table->longText('remarks')->nullable();
            $table->string('requirement_status')->default('For Compliance');
            $table->string('complied_on')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('honorarium_id')->references('id')->on('honorarium');
            $table->foreign('office')->references('id')->on('office');
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
