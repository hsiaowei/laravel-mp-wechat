<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WxCompanyInfo extends Model
{
    //
    protected $table='wx_company_info';
    protected $primaryKey = 'company_id';

    public function getCompanyId($companyno,$companyname)
    {
        return $this->select('company_id')->where([['company_no','=',$companyno],
                              ['company_name','=',$companyname]
                             ])->get()->toArray();
    }
}
