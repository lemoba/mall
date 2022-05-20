<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('产品名称');
            $table->string('desc')->default('')->comment('产品描述');
            $table->unsignedInteger('stock')->default('0')->comment('产品库存');
            $table->decimal('amount', 8, 2)->default('0')->comment('产品金额');
            $table->unsignedTinyInteger('status')->default('0')->comment('产品状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
