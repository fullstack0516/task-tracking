<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToProspectTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('prospect_projects', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('prospect_communications', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('prospect_projects', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('prospect_communications', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
