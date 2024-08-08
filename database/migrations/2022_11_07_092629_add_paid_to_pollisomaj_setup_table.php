<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToPollisomajSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_setup', function (Blueprint $table) {
            $table->integer('general_member_pwd_total')->after('mob_4')->nullable($value=true);
            $table->integer('member_transgender_pwd')->after('mob_4')->nullable($value=true);
            $table->integer('member_male_pwd')->after('mob_4')->nullable($value=true);
            $table->integer('member_female_pwd')->after('mob_4')->nullable($value=true);
            $table->integer('member_boys_pwd')->after('mob_4')->nullable($value=true);
            $table->integer('member_girls_pwd')->after('mob_4')->nullable($value=true);
            $table->integer('general_member_total')->after('mob_4')->nullable($value=true);
            $table->integer('member_transgender')->after('mob_4')->nullable($value=true);
            $table->integer('member_male')->after('mob_4')->nullable($value=true);
            $table->integer('member_female')->after('mob_4')->nullable($value=true);
            $table->integer('member_boys')->after('mob_4')->nullable($value=true);
            $table->integer('member_girls')->after('mob_4')->nullable($value=true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pollisomaj_setup', function (Blueprint $table) {
            //
        });
    }
}
