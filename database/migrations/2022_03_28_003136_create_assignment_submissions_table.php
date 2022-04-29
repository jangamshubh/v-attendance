<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->text('answer');
            $table->text('file_link')->nullable();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('assignment_id')->constrained('assignments');
            $table->text('obtained_marks')->nullable();
            $table->text('answer_added_at')->nullable();
            $table->text('marks_added_at')->nullable();
            $table->text('teacher_comments')->nullable();
            $table->integer('is_auto_evaluated')->nullable();
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
        Schema::dropIfExists('assignment_submissions');
    }
}
