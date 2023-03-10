<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WxPersonalInformationPage extends Model
{
    //
    protected $table='wx_personal_information_page';

    public function getPersonInfo($companyid,$empno)
    {
        $result= $this->where([['company_id','=',$companyid],
                               ['emp_no','=',$empno]
                               ] )->select('*')->get();
        //$result= $result->toArray();
        return  $result;
    }
}
