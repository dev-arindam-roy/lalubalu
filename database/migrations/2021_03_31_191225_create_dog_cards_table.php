<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('dog_breed_id');
            $table->foreign('dog_breed_id')->references('id')->on('dog_breeds')->onDelete('cascade');
            $table->dateTime('date_of_birth')->nullable();
            $table->string('gender');
            $table->string('owner_name');
            $table->string('owner_contact_number');
            $table->string('owner_email_address')->nullable();
            $table->string('living_address')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=Inactive, 1=Active, 2=Blocked, 3=Deleted');
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
        Schema::dropIfExists('dog_cards');
    }
}
