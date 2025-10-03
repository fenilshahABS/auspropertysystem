<?php

namespace App\Containers\AppSection\Workermaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Containers\AppSection\Workermaster\Tasks\UpdateWorkermasterTask;
use App\Containers\AppSection\Workermaster\UI\API\Requests\UpdateWorkermasterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateWorkermasterAction extends ParentAction
{
    /**
     * @param UpdateWorkermasterRequest $request
     * @return Workermaster
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdateWorkermasterRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            // add your request data here
            'worker_name' => $InputData->getWorkerName(),
            'worker_mobile_no' => (string)$InputData->getWorkerMobileNo(),
            'worker_email' => $InputData->getWorkerEmail(),
            'worker_address' => $InputData->getWorkerAddress(),
            'worker_city' => $InputData->getWorkerCity(),
            'worker_state' => $InputData->getWorkerState(),
            'worker_country' => $InputData->getWorkerCountry(),
            'worker_zip_code' => $InputData->getWorkerZipCode(),
        ]);

        return app(UpdateWorkermasterTask::class)->run($data, $request->id);
    }
}
