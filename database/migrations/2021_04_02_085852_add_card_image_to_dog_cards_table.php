<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardImageToDogCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dog_cards', function (Blueprint $table) {
            $table->longText('card_image')->nullable()->after('dog_image');
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
            $table->dropColumn('card_image');
        });
    }
}
