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
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_subject_id')->nullable();

            // Relasi ke schedule_subject
            $table->foreign('schedule_subject_id')->references('id')->on('schedule_subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['schedule_subject_id']);
            $table->dropColumn('schedule_subject_id');
        });
    }
};
