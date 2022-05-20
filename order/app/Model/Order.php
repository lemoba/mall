<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;
/**
 */
class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uid',
        'pid',
        'amount'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
}