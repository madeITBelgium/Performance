<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestDataJoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_data_joins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_data_id')->nullable();
            $table->string('string1');
            $table->string('string2');
            $table->string('string3');
            $table->string('string4');
            $table->string('string5');
            $table->integer('number1');
            $table->integer('number2');
            $table->integer('number3');
            $table->integer('number4');
            $table->integer('number5');
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
        Schema::dropIfExists('test_data_joins');
    }
}
