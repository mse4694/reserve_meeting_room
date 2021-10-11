<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedInteger('resourceId');
            $table->unsignedInteger('attendees');
            $table->string('coordinator', 200);
            $table->unsignedInteger('workunit_id');
            $table->string('tel', 100)->nullable();
            $table->json('equipment')->nullable();
            $table->json('food_drink')->nullable();
            $table->boolean('status')->default(false);
            $table->string('userin');
            $table->string('user_last_act')->nullable();
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
        Schema::dropIfExists('events');
    }
}
