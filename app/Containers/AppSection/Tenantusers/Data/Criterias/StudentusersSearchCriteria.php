<?php
namespace App\Containers\AppSection\Tenantusers\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Request;
use Illuminate\Support\Facades\Auth;
use Apiato\Core\Traits\HashIdTrait;

/**
 * Class CatalogsSearchCriteria.
 *
 * @author  Rockers Technologies <jaimin.rockersinfo@gmail.com
 */
class StudentusersSearchCriteria extends Criteria
{
    /**
     * @param $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
     use HashIdTrait;
    public function apply($model, PrettusRepositoryInterface $repository)
    {
    	$keyword = Request::post('keyword');
      $location_id = Request::post('location_id');
      if($location_id!=""){
        $location_id = $this->decode($location_id);
      }
      $getTenant = Auth::user();
      $tenant_id = $getTenant['tenant_id'];

      if ($keyword != "") {
        //echo "if";die;
        if($location_id==""){
            return $model->select('jp_tenantusers.*')
                         ->where("jp_tenantusers.tenant_id", $tenant_id)
                         ->where("jp_tenantusers.role_id", 3)
                         ->whereRaw("(jp_tenantusers.alternate_id like '%".$keyword."%' or jp_tenantusers.first_name like '%".$keyword."%' or jp_tenantusers.middle_name like '%".$keyword."%' or jp_tenantusers.last_name like '%".$keyword."%')");
        }else{
            return $model->select('jp_tenantusers.*')
                         ->where("jp_tenantusers.tenant_id", $tenant_id)
                         ->where("jp_tenantusers.role_id", 3)
                         ->where("jp_tenantusers.location_id", $location_id)
                         ->whereRaw("(jp_tenantusers.alternate_id like '%".$keyword."%' or jp_tenantusers.first_name like '%".$keyword."%' or jp_tenantusers.middle_name like '%".$keyword."%' or jp_tenantusers.last_name like '%".$keyword."%')");
        }
      }else{
        //echo "else";die;
        if($location_id==""){
            return $model->select('jp_tenantusers.*')
                         ->where("jp_tenantusers.tenant_id", $tenant_id)
                         ->where("jp_tenantusers.role_id", 3);
        }else{
            return $model->select('jp_tenantusers.*')
                         ->where("jp_tenantusers.tenant_id", $tenant_id)
                         ->where("jp_tenantusers.role_id", 3)
                         ->where("jp_tenantusers.location_id", $location_id);
        }
      }


      //return $model->groupBy('jp_tenantusers.id');
    }
}
