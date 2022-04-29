<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('total_marks');
            $table->text('start_date_time');
            $table->text('end_date_time');
            $table->integer('allow_late_submision');
            $table->text('rubric')->nullable();
            $table->text('more_info_link')->nullable();
            $table->foreignId('added_by')->contrained('users');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->integer('visibility')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('assignments');
    }
}
