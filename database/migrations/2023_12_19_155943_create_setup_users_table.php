<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('employee_pin')->nullable();
            $table->string('employee_name')->nullable();
            $table->integer('region_id');
            $table->integer('status')->default(1);
            $table->date('date_from')->nullable($value=true)->default($value=date('Y-m-d'));
            $table->date('date_to')->nullable($value=true);
            $table->softDeletes();
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
        Schema::dropIfExists('setup_users');
    }
}
