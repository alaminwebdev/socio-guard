<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->nullable();
            $table->bigInteger('employee_pin')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('ip_address')->nullable();
            $table->date('login_time')->nullable();
            $table->date('logout_time')->nullable();
            $table->bigInteger('complain_id')->nullable();
            $table->bigInteger('pollisomaj_data_id')->nullable();
            $table->string('changing_page')->nullable();
            $table->string('description')->nullable();
            $table->string('table_name')->nullable();
            $table->smallInteger('action_type')->nullable()->comment('1 = Inserted , 2 = Updated, 3 = Deleted, 4 = Report Generate, 5 = Login, 6 = Logout');
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
        Schema::dropIfExists('audit_logs');
    }
}
