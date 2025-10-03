<?php

namespace App\Containers\AppSection\Workermaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Containers\AppSection\Workermaster\Tasks\CreateWorkermasterTask;
use App\Containers\AppSection\Workermaster\UI\API\Requests\CreateWorkermasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateWorkermasterAction extends ParentAction
{
    /**
     * @param CreateWorkermasterRequest $request
     * @return Workermaster
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreateWorkermasterRequest $request, $InputData)
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

        return app(CreateWorkermasterTask::class)->run($data);
    }
}
