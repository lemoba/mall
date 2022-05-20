<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('用户姓名');
            $table->unsignedTinyInteger('gender')->default('0')->comment('用户性别');
            $table->string('mobile', 11)->default('')->comment('用户电话');
            $table->string('password')->default('')->comment('用户密码');
            $table->timestamps();
            $table->unique('mobile', 'idx_mobile_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
