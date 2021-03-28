<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detaileds', function (Blueprint $table) {
            $table->id();
            $table->string("en",100);
            $table->string("ar",100);

            $table->unsignedBigInteger('master_id')->nullable();;
            $table->foreign('master_id')->references('id')->on('masters')->onDelete('cascade');

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
        Schema::dropIfExists('detaileds');
    }
}
