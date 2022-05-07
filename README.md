## 商城微服务

### 1. 环境搭建

#### 1. 2 数据表

```php
// user
$table->bigIncrements('id');
$table->string('name')->default('')->comment('用户姓名');
$table->unsignedTinyInteger('gender')->default('0')->comment('用户性别');
$table->string('mobile', 11)->default('')->comment('用户电话');
$table->string('password')->default('')->comment('用户密码');
$table->timestamps();
$table->unique('mobile', 'idx_mobile_unique');

// prodcut
$table->bigIncrements('id');
$table->string('name')->default('')->comment('产品名称');
$table->string('desc')->default('')->comment('产品描述');
$table->unsignedInteger('stock')->default('0')->comment('产品库存');
$table->decimal('amount', 8, 2)->default('0')->comment('产品金额');
$table->unsignedTinyInteger('status')->default('0')->comment('产品状态');
$table->timestamps();

// pay
$table->bigIncrements('id');
$table->unsignedBigInteger('uid')->default('0')->comment('用户ID');
$table->unsignedBigInteger('oid')->default('0')->comment('订单ID');
$table->decimal('amount', 8, 2)->default('0')->comment('产品金额');
$table->unsignedTinyInteger('source')->default('0')->comment('支付方式');
$table->unsignedTinyInteger('status')->default('0')->comment('支付状态');
$table->timestamps();
$table->index('uid','idx_uid');
$table->index('oid','idx_oid');

// order
$table->bigIncrements('id');
$table->unsignedBigInteger('uid')->default('0')->comment('用户ID');
$table->unsignedBigInteger('pid')->default('0')->comment('产品ID');
$table->decimal('amount', 8, 2)->default('0')->comment('订单金额');
$table->unsignedTinyInteger('status')->default('0')->comment('订单状态');
$table->timestamps();
$table->index('uid', 'idx_uid');
$table->index('pid', 'idx_pid');
```

​        