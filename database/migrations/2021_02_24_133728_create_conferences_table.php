<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('acronym');
            $table->integer('user_id');
            $table->integer('status');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('abstract_submission_date');
            $table->date('full_paper_date');
            $table->date('acceptance_notification_date');
            $table->string('place');
            $table->text('logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conferences');
    }
}
