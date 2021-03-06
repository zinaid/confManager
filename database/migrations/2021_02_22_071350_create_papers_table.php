<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('abstract');
            $table->text('keywords');
            $table->integer('paper_number');  
            $table->integer('author');
            $table->integer('type');
            $table->integer('student');
            $table->integer('conference');  
            $table->integer('section');    
            $table->integer('topic_area');
            $table->text('file');
            $table->dateTime('created_at'); 
            $table->integer('status');
            $table->text('paper_timestamp');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers');
    }
}
