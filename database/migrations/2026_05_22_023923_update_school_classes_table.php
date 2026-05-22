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
        Schema::table('school_classes', function (Blueprint $table) {

            // Remove section column
            $table->dropColumn('section');

            // Add room_id
            $table->foreignId('room_id')
                  ->nullable()
                  ->after('teacher_id')
                  ->constrained()
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_classes', function (Blueprint $table) {

            // Restore section
            $table->string('section');

            // Remove room_id
            $table->dropConstrainedForeignId('room_id');
        });
    }
};