<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'stock',
        'amount',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'stock' => 'integer',
        'amount' => 'double'
    ];

    protected $hidden = [
        'updated_at'
    ];
}