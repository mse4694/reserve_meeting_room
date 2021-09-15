<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetingrooms', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('building_id');
            $table->smallInteger('floor');
            $table->json('capacity');
            $table->json('price');
            $table->string('fullname');
            $table->string('shortname');
            $table->json('description')->nullable();
            $table->string('status');
            $table->string('userin');
            $table->string('user_last_act')->nullable();
            $table->json('img_file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetingrooms');
    }
}
