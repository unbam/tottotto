<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * カテゴリモデル
 * @package App
 */
class Category extends Model
{
    protected $fillable = ['name'];
}
