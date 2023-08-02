<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->unsignedBigInteger('event_id');
            $table->string('type');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('cart_id');
            $table->boolean('is_used')->default(false);
            $table->unsignedBigInteger('user_id');            
            $table->unsignedBigInteger('used_by')->nullable();
            $table->foreign('used_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
