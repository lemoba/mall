<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid')->default('0')->comment('用户ID');
            $table->unsignedBigInteger('oid')->default('0')->comment('订单ID');
            $table->decimal('amount', 8, 2)->default('0')->comment('产品金额');
            $table->unsignedTinyInteger('source')->default('0')->comment('支付方式');
            $table->unsignedTinyInteger('status')->default('0')->comment('支付状态');
            $table->timestamps();
            $table->index('uid','idx_uid');
            $table->index('oid','idx_oid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
}
