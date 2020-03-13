<?php

namespace App\relations;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['foreign_key', 'type', 'tag'];
    protected $table = 'tags';
}
