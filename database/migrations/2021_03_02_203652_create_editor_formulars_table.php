<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditorFormularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editor_formulars', function (Blueprint $table) {
            $table->id(); 
            $table->date('created_at');
            $table->integer('decision')->default(0); 
            $table->integer('status')->default(0);
            $table->integer('editor_id');
            $table->integer('paper_id');
            $table->date('decision_date')->nullable();
            $table->string('ip_timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editor_formulars');
    }
}
