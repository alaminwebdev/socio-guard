<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateOfDisputeAndPostingDateToSelpIncidentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->date('date_of_dispute')->nullable($value=true)->after('violence_reason_id');
            $table->date('posting_date')->nullable($value=true)->after('complain_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('selp_incident_informations', function (Blueprint $table) {
            $table->dropColumn('date_of_dispute');
            $table->dropColumn('posting_date');
        });
    }
}
