<?php

namespace App\Models\Hr;

use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notice extends Model
{
    //
    protected $table = 'wx_notice';
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'type', 'status'
    ];


}
