<?php

namespace App\Containers\AppSection\Workermaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Workermaster\Data\Repositories\WorkermasterRepository;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Apiato\Core\Traits\HashIdTrait;

class GetAllWorkermastersBySearchTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected WorkermasterRepository $repository
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run($InputData)
    {

        try {
            $returnData = array();
            $per_page = (int) $InputData->getPerPage();

            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();

            if (($field_db == "") || ($field_db == NULL)) {
                $getData = Workermaster::orderBy('created_at', 'DESC')->paginate($per_page);
            } else {

                $getData = Workermaster::where($field_db, 'like', '%' . $search_val . '%')->paginate($per_page);
            }

            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_worker_master";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['worker_name'] = $getData[$i]->worker_name;
                    $returnData['data'][$i]['worker_mobile_no'] = $getData[$i]->worker_mobile_no;
                    $returnData['data'][$i]['worker_email'] = $getData[$i]->worker_email;
                    $returnData['data'][$i]['worker_address'] = $getData[$i]->worker_address;
                    $returnData['data'][$i]['worker_city'] = $getData[$i]->worker_city;
                    $returnData['data'][$i]['worker_state'] = $getData[$i]->worker_state;
                    $returnData['data'][$i]['worker_country'] = $getData[$i]->worker_country;
                    $returnData['data'][$i]['worker_zip_code'] = $getData[$i]->worker_zip_code;
                    $returnData['data'][$i]['is_active'] = $getData[$i]->is_active;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                }
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData = [
                    'message' => 'Data Not Found',
                    'object' => 'pro_worker_master',
                    'data' => [],
                ];
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
