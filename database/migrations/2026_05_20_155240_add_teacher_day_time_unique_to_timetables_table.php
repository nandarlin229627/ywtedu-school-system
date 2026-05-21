<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasColumn('timetables', 'teacher_time_unique')) {
        Schema::table('timetables', function (Blueprint $table) {
            $table->unique(['teacher_id', 'day', 'time'], 'teacher_time_unique');
        });
    }
}

    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropUnique('teacher_time_unique');
        });
    }
};