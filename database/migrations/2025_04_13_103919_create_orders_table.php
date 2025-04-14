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
        $table->unsignedBigInteger('UserID')->nullable();
        $table->timestamp('OrderDate');
        $table->decimal('TotalAmount', 10, 2);  // Kiểu dữ liệu tiền tệ
        $table->string('StatusOrders');
        $table->string('customer_name');
        $table->string('address');
        $table->string('phone');
        $table->text('note')->nullable();
        $table->timestamps();
         // Ràng buộc khóa ngoại cho user_id (tham chiếu đến bảng users)
            $table->foreign('UserID')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['UserID']); // Xóa foreign key trước khi xóa bảng
            $table->timestamp('OrderDate')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::dropIfExists('orders'); // Xóa bảng orders
    }
}
