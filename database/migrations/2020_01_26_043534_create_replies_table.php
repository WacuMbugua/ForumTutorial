<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    protected $fillable = [ "user_id"];

    public function up()
    {
        Schema::dropIfExists('replies');
        Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('thread_id');
            $table->integer('user_id');
            $table->text('body');
            $table->timestamps();

            //$table->foreign('thread_id')->onDelete('cas')
        });
    }


}
