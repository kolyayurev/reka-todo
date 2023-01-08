<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_tag', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('card_id');
            $table->unsignedBigInteger('tag_id');

            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('cards')->onUpdate('cascade')->cascadeOnDelete();
            $table->foreign('tag_id')->references('id')->on('cards')->onUpdate('cascade')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_tag');
    }
};
