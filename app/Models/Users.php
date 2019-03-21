<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $primaryKey = 'user_id';
    public $timestamps=false;
}
