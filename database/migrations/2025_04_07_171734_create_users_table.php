<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->id('DiscountID');
            $table->decimal('DiscountValue', 5, 2);  // Phần trăm giảm giá
            $table->date('StartDate');
            $table->date('EndDate');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}