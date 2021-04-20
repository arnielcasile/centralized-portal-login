<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('system_access_id');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->timestamps();
            $table->foreign('system_access_id')->references('id')->on('system_accesses');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_accesses');
    }
}
