<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'cart';
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $primaryKey = 'cart_id';
    public $timestamps=false;
}
