<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('tracks');
        Schema::dropIfExists('artists');

        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('subscribers_count')->default(0);
            $table->integer('listeners_month_count')->default(0);
            $table->integer('albums_count')->default(0);
            $table->string('artist_info', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artist_id');
            $table->string('name');
            $table->time('duration');
            $table->string('album')->nullable();
            $table->timestamps();

            $table->foreign('artist_id')->references('id')->on('artists');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
        Schema::dropIfExists('artists');
    }
};
