<?php

namespace App\Containers\AppSection\Propertytype\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Propertytype\Data\Repositories\PropertytypeRepository;
use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllPropertytypesBySearchTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PropertytypeRepository $repository
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
                $getData = Propertytype::orderBy('created_at', 'DESC')->paginate($per_page);
            } else {

                $getData = Propertytype::where($field_db, 'like', '%' . $search_val . '%')->paginate($per_page);
            }

            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_property_type_master";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['type'] = $getData[$i]->type;
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
                    'object' => 'pro_property_type_master',
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
