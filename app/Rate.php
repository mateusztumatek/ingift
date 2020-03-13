<?php

namespace App;

use App\Services\myModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Rate extends myModel
{
    protected $fillable = ['foreign_key', 'author', 'content', 'rate', 'type'];
    protected $appends = ['created_diff'];
    public function getCreatedDiffAttribute(){
        return $this->created_at->diffForHumans();
    }
}
