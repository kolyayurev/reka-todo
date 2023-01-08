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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            $table->string('name'); 
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('done')->default(false);

            $table->unsignedBigInteger('list_id')->nullable();
            
            $table->timestamps();

            $table->foreign('list_id')->references('id')->on('lists')->onUpdate('cascade')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
