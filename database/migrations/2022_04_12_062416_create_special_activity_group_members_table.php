<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialActivityGroupMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_activity_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('special_activity_group_id')->constrained('special_activity_group');
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('added_by')->constrained('users');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('special_activity_group_members');
    }
}
