<?php

namespace App\Containers\AppSection\Tenantusers\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantusers\Data\Repositories\TenantusersRepository;
use App\Containers\AppSection\Tenantusers\Models\Tenantusers;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetAllTenantuserBySearchTask extends Task
{
    use HashIdTrait;
    protected TenantusersRepository $repository;

    public function __construct(TenantusersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($InputData)
    {
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $per_page = (int) $InputData->getPerPage();
            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();
            if (($field_db == "") || ($field_db == NULL)) {
                if (!empty($per_page)) {
                    $getData = Tenantusers::orderBy('created_at', 'DESC')->paginate($per_page);
                } else {
                    $getData = Tenantusers::orderBy('created_at', 'DESC')->get();
                }
            } else {
                if ($field_db == "role_id") {
                    $search_val = $this->decode($search_val);
                }
                if (!empty($per_page)) {
                    $getData = Tenantusers::where($field_db, 'like', '%' . $search_val . '%')->orderBy('created_at', 'DESC')->paginate($per_page);
                } else {
                    $getData = Tenantusers::where($field_db, 'like', '%' . $search_val . '%')->orderBy('created_at', 'DESC')->get();
                }
            }
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_tenantusers";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['role_id'] = $this->encode($getData[$i]['role_id']);
                    $returnData['data'][$i]['first_name'] = $getData[$i]['first_name'];
                    $returnData['data'][$i]['last_name'] = $getData[$i]['last_name'];
                    $returnData['data'][$i]['profile_image'] = ($getData[$i]['profile_image']) ? $image_api_url->image_api_url . $getData[$i]['profile_image'] : "";
                    $returnData['data'][$i]['id_proof'] = ($getData[$i]['id_proof']) ? $image_api_url->image_api_url . $getData[$i]['id_proof'] : "";
                    $returnData['data'][$i]['dob'] = $getData[$i]['dob'];
                    $returnData['data'][$i]['gender'] = $getData[$i]['gender'];
                    $returnData['data'][$i]['email'] = $getData[$i]['email'];
                    $returnData['data'][$i]['mobile'] = $getData[$i]['mobile'];
                    $returnData['data'][$i]['address'] = $getData[$i]['address'];
                    $returnData['data'][$i]['country'] = $getData[$i]['country'];
                    $returnData['data'][$i]['state'] = $getData[$i]['state'];
                    $returnData['data'][$i]['city'] = $getData[$i]['city'];
                    $returnData['data'][$i]['zipcode'] = $getData[$i]['zipcode'];
                    $returnData['data'][$i]['is_active'] = $getData[$i]['is_active'];
                    $returnData['data'][$i]['is_verify'] = $getData[$i]['is_verify'];
                }
                if (!empty($per_page)) {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_tenantusers";

                if (!empty($per_page)) {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
