<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMycommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mycomments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id");

            $table->unsignedBigInteger("discussion_id");
            $table->index("discussion_id");

            $table->text("comment");
            $table->boolean("approved")->default(true);

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
        Schema::dropIfExists('mycomments');
    }
}
