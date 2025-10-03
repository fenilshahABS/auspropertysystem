<?php

namespace App\Containers\AppSection\Propertymaster\Tasks;

use App\Containers\AppSection\Propertymaster\Data\Repositories\PropertymasterRepository;
use App\Containers\AppSection\Propertymaster\Models\Propertymaster;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePropertymasterByFieldsTask extends ParentTask
{
    public function __construct(
        protected PropertymasterRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($InputData, $id)
    {
        try {
            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();
            if (strtolower($InputData->getFlag()) == "propertydetails") {
                $property_master_data = PropertymasterDetails::where('id', $id)->first();

                if ($property_master_data->property_status == 2 || $property_master_data->property_status == 9) {
                    $returnData['message'] = "Cannot Update Property That is Already on Rent or in Maintenance";
                    return $returnData;
                    // throw new Exception("Cannot Update Property That is Already on Rent or in Maintenance");
                } elseif ($search_val == 9 || $search_val == 2) {
                    $returnData['message'] = "Cannot Update Property To Rent Or Maintenance Directly";
                    return $returnData;
                    // throw new Exception("Cannot Update Property To Rent Or Maintenance Directly");
                }
                $propertyDetails = PropertymasterDetails::where('id', $id)->update([$field_db => $search_val]);
                $id = PropertymasterDetails::find($id)->pro_property_master_id;
            } else {
                $propertymaster = Propertymaster::where('id', $id)->update([$field_db => $search_val]);
                if ($propertymaster) {
                    if ($field_db == "status" && $search_val == 0) {
                        $propertyDetails = PropertymasterDetails::where('pro_property_master_id', $id)->update(["property_status" => $search_val]);
                    }
                }
            }

            return $this->repository->find($id);
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
