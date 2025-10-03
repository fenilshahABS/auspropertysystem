<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\UpdateRentalPropertyManagementWorkersTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\UpdateRentalPropertyManagementExpenseRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateRentalPropertyManagementWorkersAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateRentalPropertyManagementExpenseRequest $request, $InputData)
    {

        $worker_id = $this->decode($InputData->getWorkerDetailsId());

        $data = $request->sanitizeInput([
            "worker_amount" => $InputData->getWorkerAmount(),
            "worker_amount_paid_status" => $InputData->getWorkerAmountPaidStatus(),
            "worker_amount_paid_transaction" => $InputData->getWorkerAmountPaidTransaction(),
            "worker_amount_paid_date" => $InputData->getworkerAmountPaidDate(),
            "worker_notes" => $InputData->getWorkerNotes(),
            "worker_amount_type" => $InputData->getWorkerAmountType(),
        ]);
        $data = array_filter($data);
        return app(UpdateRentalPropertyManagementWorkersTask::class)->run($data, $worker_id);
    }
}
