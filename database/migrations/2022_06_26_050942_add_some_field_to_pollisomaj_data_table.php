<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldToPollisomajDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_data', function (Blueprint $table) {
            $table->integer('employee_id')->after('id')->nullable($value=true);
            $table->integer('employee_pin')->after('id')->nullable($value=true);
            $table->integer('pollisomaj_no')->after('pollisomaj_data_ref')->nullable($value=true);
            $table->integer('number_of_child_marriage')->after('c_number')->nullable($value=true);
            $table->integer('f_number')->after('c_number')->nullable($value=true);
            $table->string('village_name')->after('union_id')->nullable($value=true);
            $table->integer('girls_got_married_under_18_finally_pwd')->after('girls_got_married_finally_pwd')->nullable($value=true);
            $table->integer('girls_got_married_at_18_finally')->after('girls_got_married_finally_pwd')->nullable($value=true);
            $table->integer('session_with_ps_pwd')->after('session_with_ps_transgender')->nullable($value=true);
            $table->dropColumn('village_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pollisomaj_data', function (Blueprint $table) {
            $table->dropColumn('employee_id');
            $table->dropColumn('employee_pin');
            $table->dropColumn('pollisomaj_no');
            $table->dropColumn('number_of_child_marriage');
            $table->dropColumn('f_number');
            $table->dropColumn('village_name');
            $table->dropColumn('girls_got_married_under_18_finally_pwd');
            $table->dropColumn('girls_got_married_at_18_finally');
            $table->dropColumn('session_with_ps_pwd');
        });
    }
}
