<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
{
    Schema::create('products', function (Blueprint $table) {
        $table->id('ProductID');
        $table->string('ProductName');
        $table->text('Description')->nullable();
        $table->decimal('Price', 10, 2);
        $table->integer('Stock');
        $table->unsignedBigInteger('CategoryID');
        $table->string('ImageURL')->nullable();
        $table->timestamps();

        $table->foreign('CategoryID')->references('CatalogID')->on('catalog')->onDelete('cascade');
    });
}

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
