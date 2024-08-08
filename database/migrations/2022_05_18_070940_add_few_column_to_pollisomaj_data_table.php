<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFewColumnToPollisomajDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pollisomaj_data', function (Blueprint $table) {
                $table->integer('sexual_harassment')->after('physical_torture_contact')->nullable($value=true);
                $table->string('sexual_harassment_name')->after('sexual_harassment')->nullable($value=true);
                $table->string('sexual_harassment_gurdian')->after('sexual_harassment_name')->nullable($value=true);
                $table->string('sexual_harassment_village')->after('sexual_harassment_gurdian')->nullable($value=true);
                $table->string('sexual_harassment_contact')->after('sexual_harassment_village')->nullable($value=true);
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
                $table->dropColumn('sexual_harassment');
                $table->dropColumn('sexual_harassment_name');
                $table->dropColumn('sexual_harassment_gurdian');
                $table->dropColumn('sexual_harassment_village');
                $table->dropColumn('sexual_harassment_contact');
        });
    }
}
