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
            $table->tinyInteger('objective_id');
            $table->longText('title');
            $table->longText('detail')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->tinyInteger('prepare')->default(0);
            $table->tinyInteger('resourceId');
            $table->unsignedInteger('attendees');
            $table->string('responsible_person', 300);
            $table->string('coordinator', 300);
            $table->unsignedInteger('workunit_id');
            $table->string('tel', 100)->nullable();
            $table->json('equipment')->nullable();
            $table->json('food_drink')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->longText('reason')->nullable();
            $table->unsignedInteger('questionnair')->default(0);
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
