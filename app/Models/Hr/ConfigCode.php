<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

class ConfigCode extends Model
{
    //
    protected $table='wx_config_code';
    public $timestamps		=	true;
    protected $primaryKey	=	'id';
    public $incrementing	=	true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * 根据类型获取code详情
     *  getCodeByType
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-08 16:14:16
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getCodeByType($type)
    {
        return $this->where('type',$type)->get()->toArray();
    }


}
