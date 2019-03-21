<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'goods';
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $primaryKey = 'goods_id';
}
