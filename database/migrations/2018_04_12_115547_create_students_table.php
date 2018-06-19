<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('fathers_name', 100)->nullable();
            $table->string('mothers_name', 100)->nullable();
            $table->string('cellphone')->nullable();
            $table->string('address')->nullable();
            $table->integer('numberHouse')->nullable();
            $table->string('complement', 50)->nullable();
            $table->string('neighborhood', 50)->nullable();
            $table->string('city', 40)->nullable();
            $table->string('internal_code', 20)->nullable();
            $table->string('registry', 20)->nullable(); // matricula
            $table->date('birthday')->nullable(); // matricula
            $table->integer('status');
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
        Schema::dropIfExists('students');
    }
}
