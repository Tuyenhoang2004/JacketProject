<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('OrderID');
            $table->foreignId('UserID')->constrained('users');  // Liên kết với bảng users
            $table->decimal('TotalAmount', 10, 2);
            $table->string('PaymentMethod');
            $table->string('Status');
            $table->string('ShippingAddress');
            $table->timestamp('OrderDate')->useCurrent();
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
        Schema::dropIfExists('orders');
    }
}
