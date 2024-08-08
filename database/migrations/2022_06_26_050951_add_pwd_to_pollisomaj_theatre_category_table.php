<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPwdToPollisomajTheatreCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_theatre_category', function (Blueprint $table) {
            $table->integer('theatre_perticipent_transgender_pwd')->after('par_transgender')->nullable($value=true);
            $table->integer('theatre_perticipent_men_pwd')->after('par_transgender')->nullable($value=true);
            $table->integer('theatre_perticipent_women_pwd')->after('par_transgender')->nullable($value=true);
            $table->integer('theatre_perticipent_boy_pwd')->after('par_transgender')->nullable($value=true);
            $table->integer('theatre_perticipent_girl_pwd')->after('par_transgender')->nullable($value=true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pollisomaj_theatre_category', function (Blueprint $table) {
            $table->dropColumn('theatre_perticipent_transgender_pwd');
            $table->dropColumn('theatre_perticipent_men_pwd');
            $table->dropColumn('theatre_perticipent_women_pwd');
            $table->dropColumn('theatre_perticipent_boy_pwd');
            $table->dropColumn('theatre_perticipent_girl_pwd');
        });
    }
}
