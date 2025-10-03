<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Tasks\UpdateRentalPropertyManagementTask;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\UpdateRentalPropertyManagementRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateRentalPropertyManagementAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateRentalPropertyManagementRequest $request, $InputData)
    {
        $user_id = $this->decode($InputData->getUserId());

        $data = $request->sanitizeInput([
            // "property_master_id" => $InputData->getPropertyMasterId(),
            // "pro_property_master_details_id" => $InputData->getProPropertyMasterDetailsId(),
            "lease_start_date" => $InputData->getLeaseStartDate(),
            "lease_end_date" => $InputData->getLeaseEndDate(),
            //  "user_id" => $InputData->getUserId(),
            "rent_date" => $InputData->getRentDate(),
            "rent_frequency" => $InputData->getRentFrequency(),
            "rent_amount" => $InputData->getRentAmount(),
            "security_deposit" => $InputData->getSecurityDeposit(),
            "advance_amount" => $InputData->getAdvanceAmount(),
            "late_fees" => $InputData->getLateFees(),
            //      "lease_document" => $InputData->getLeaseDocument(),
        ]);
        $data['property_master_id'] = $this->encode($InputData->getPropertyMasterId());
        $data['pro_property_master_details_id'] = $this->encode($InputData->getProPropertyMasterDetailsId());
        $data['user_id'] = $user_id;


        $lease_document = $InputData->getLeaseDocument();
        if ($InputData->getLeaseDocument() != null) {
            if (!file_exists(public_path('lease_document/'))) {
                mkdir(public_path('lease_document/'), 0755, true);
            }

            list($type, $data_type) = explode(';', $lease_document);
            list(, $data_type) = explode(',', $data_type);
            $folderPath = 'public/lease_document/';
            $image_bace64 = base64_decode($data_type);
            if ($type == "data:application/pdf") {
                $image_type = "pdf";
                $file = uniqid() . '.' . $image_type;
                $path = public_path('lease_document/' . $file);
                file_put_contents($path, $image_bace64);
            } else {
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($InputData->getLeaseDocument());
                $image_type = "png";
                $file =  uniqid() . '.' . $image_type;
                $saveimage = $image->toPng()->save(public_path('lease_document/' . $file));
                //   $chatImage  =  $folderPath . $file;
            }
            $LeaseDoc =  $folderPath . $file;
        } else {
            $LeaseDoc = '';
        }

        $data['lease_document'] = $LeaseDoc;
        $data = array_filter($data);


        $late_fees_details = $InputData->getLateFeesDetails();
        if (!empty($late_fees_details)) {
            for ($j = 0; $j < count($late_fees_details); $j++) {
                $fees_details[$j] = [
                    "date_range_type" => $late_fees_details[$j]['date_range_type'],
                    "date_range_value" => $late_fees_details[$j]['date_range_value'],
                    "late_fees_amount" => $late_fees_details[$j]['late_fees_amount']
                ];
                if (isset($late_fees_details[$j]['id'])) {
                    $fees_details[$j]['id'] = $this->decode($late_fees_details[$j]['id']);
                }
            }
            $fees_details = array_filter($fees_details);
        } else {
            $fees_details = [];
        }

        return app(UpdateRentalPropertyManagementTask::class)->run($data, $request->id, $fees_details);
    }
}
