<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDogImageToDogCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dog_cards', function (Blueprint $table) {
            $table->string('dog_image')->nullable()->after('living_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dog_cards', function (Blueprint $table) {
            $table->dropColumn('dog_image');
        });
    }
}
