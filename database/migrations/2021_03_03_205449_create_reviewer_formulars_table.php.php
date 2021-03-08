<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewerFormularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewer_formulars', function (Blueprint $table) {
            $table->id();
            $table->date('created_at');
            $table->integer('reviewer_acceptance')->default(0); 
            $table->date('date_of_acceptance')->nullable();
            $table->integer('status')->default(0);
            $table->integer('reviewer_id');
            $table->integer('paper_id');
            $table->integer('decision')->default(0);
            $table->date('decision_date')->nullable();
            $table->text('ip_timestamp')->nullable();
            $table->integer('author_instructions')->default(0);
            $table->integer('paper_type')->nullable();
            $table->integer('paper_contribution')->nullable();
            $table->integer('paper_interest')->nullable();
            $table->integer('paper_structure')->nullable();
            $table->integer('paper_supplementary_parts')->nullable();
            $table->integer('paper_terminology')->nullable();
            $table->integer('paper_acceptance')->nullable();
            $table->text('reviewer_comment')->nullable();
            $table->text('reviewer_comment_editor')->nullable();
            $table->text('reviewer_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviewer_formulars');
    }
}
