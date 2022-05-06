<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid')->default('0')->comment('用户ID');
            $table->unsignedBigInteger('pid')->default('0')->comment('产品ID');
            $table->decimal('amount', 8, 2)->default('0')->comment('订单金额');
            $table->unsignedTinyInteger('status')->default('0')->comment('订单状态');
            $table->timestamps();
            $table->index('uid', 'idx_uid');
            $table->index('pid', 'idx_pid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
