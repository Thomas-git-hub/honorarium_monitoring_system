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
        Schema::create('thesis_transaction', function (Blueprint $table) {
            $table->id();

            $table->string('tracking_number')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('degree_id');
            $table->unsignedBigInteger('defense_id');
            $table->unsignedBigInteger('adviser_id');
            $table->unsignedBigInteger('chairperson_id');
            $table->json('member_ids')->nullable();
            $table->unsignedBigInteger('recorder_id');
            $table->string('or_number');
            $table->string('defense_date');
            $table->string('defense_time');
            $table->string('created_by');
            $table->unsignedBigInteger('created_on');
            $table->string('updated_by');
            $table->unsignedBigInteger('updated_on');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('student_id')->references('id')->on('thesis_student');
            $table->foreign('degree_id')->references('id')->on('thesis_degree');
            $table->foreign('defense_id')->references('id')->on('thesis_defense');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_transaction');
    }
};
