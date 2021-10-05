<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workunits', function (Blueprint $table) {
            $table->id();
            $table->string('workunit_name');
            $table->string('workunit_type');
            $table->string('workunit_detail', 500)->nullable();
            $table->string('userin');
            $table->string('user_last_act')->nullable();
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
        Schema::dropIfExists('workunits');
    }
}
