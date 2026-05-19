<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('teacher_id')->nullable()->constrained()->nullOnDelete();

            $table->date('date');

            $table->enum('status', ['Present', 'Absent', 'Late']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
