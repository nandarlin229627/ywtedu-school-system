
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->string('staff_no')->unique();

            $table->string('name');

            $table->string('email')->unique();

            $table->string('phone');

            $table->string('role');

            $table->string('department')->nullable();

            $table->integer('experience')->default(0);

            $table->decimal('salary', 10, 2)->default(0);

            $table->enum('status', [
                'active',
                'leave'
            ])->default('active');

            $table->integer('attendance')->default(100);

            $table->text('address')->nullable();

            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff');
    }
}