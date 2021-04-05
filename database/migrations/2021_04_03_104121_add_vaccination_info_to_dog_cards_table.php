<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVaccinationInfoToDogCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dog_cards', function (Blueprint $table) {
            $table->text('vaccination_info')->nullable()->after('living_address');
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
            $table->dropColumn('vaccination_info');
        });
    }
}
