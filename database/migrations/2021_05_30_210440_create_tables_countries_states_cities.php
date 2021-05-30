<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesCountriesStatesCities extends Migration
{

    public function up() : void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('initials');
            $table->timestamps();
        });

        Schema::create('states', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id');

            $table->string('name');
            $table->string('slug');
            $table->string('initials');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('state_id');

            $table->string('name');
            $table->string('slug');

            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('countries');
        });

    }


    public function down() : void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
}
