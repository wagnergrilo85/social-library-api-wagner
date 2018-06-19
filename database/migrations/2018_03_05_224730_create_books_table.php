<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('internal_number')->unsigned()->unique();
            $table->string('complement', 150);
            $table->string('title', 100);
            $table->string('review'); // resenha
            $table->string('subject')->nullable();
            $table->string('volume');
            $table->string('classification');
            $table->string('literature');
            $table->string('coordinator');
            $table->integer('year')->nullable();
            $table->text('description');
            $table->integer('pages')->unsigned();
            $table->string('isbn', 30)->nullable()->unique();
            $table->integer('barcode')->nullable();
            $table->string('edition', 80)->nullable();
            $table->date('releaseDate')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->default('Ativado');

            // autor id
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('authors');

            // category id
            $table->integer('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->integer('publishing_company_id');
            $table->foreign('publishing_company_id')->references('id')->on('publishing_companies');

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
        Schema::dropIfExists('books');
    }
}
