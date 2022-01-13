<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlipgridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flipgrids', function (Blueprint $table) {
            $table->id();
            $table->string('fgGridID')->nullable();
            $table->string('fgQuestionID')->nullable();
            $table->string('fgResponseID')->nullable();
            $table->text('payload')->nullable();
            $table->string('completedAt')->nullable();
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
        Schema::dropIfExists('flipgrids');
    }
}
