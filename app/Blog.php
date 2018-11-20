<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;

class Blog extends Model
{
    protected $table = "blog";

    public function adminUsers()
    {
        return $this->belongsTo(Administrator::class,'admin_id','id');
    }

}
