<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('check_elements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('checked')->default(0);
            $table->unsignedBigInteger('check_list_id');
            $table->timestamps();

            $table->foreign('check_list_id')->references('id')->on('check_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_elements');
        Schema::dropIfExists('check_lists');
    }
}
