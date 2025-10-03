<?php

namespace App\Containers\AppSection\Propertyreports\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Containers\AppSection\Propertyreports\Tasks\CreatePropertyreportsTask;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\CreatePropertyreportsRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreatePropertyreportsAction extends ParentAction
{
    /**
     * @param CreatePropertyreportsRequest $request
     * @return Propertyreports
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreatePropertyreportsRequest $request): Propertyreports
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(CreatePropertyreportsTask::class)->run($data);
    }
}
