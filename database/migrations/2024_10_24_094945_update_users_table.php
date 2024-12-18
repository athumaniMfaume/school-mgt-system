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
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'class_id')) {
            $table->unsignedBigInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        }

        if (!Schema::hasColumn('users', 'academic_year_id')) {
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->onDelete('cascade');
        }

        if (!Schema::hasColumn('users', 'father_name')) {
            $table->string('father_name')->nullable();
        }

        if (!Schema::hasColumn('users', 'mother_name')) {
            $table->string('mother_name')->nullable();
        }

        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable();
        }

        if (!Schema::hasColumn('users', 'dob')) {
            $table->string('dob')->nullable();
        }

        if (!Schema::hasColumn('users', 'admission_date')) {
            $table->date('admission_date')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['class_id', 'academic_year_id', 'father_name', 'mother_name', 'phone', 'dob', 'admission_date']);
    });
}

};
