<?php

namespace App\Containers\AppSection\Propertyreports\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Propertyreports\Models\Propertyreports;
use App\Containers\AppSection\Propertyreports\Tasks\UpdatePropertyreportsTask;
use App\Containers\AppSection\Propertyreports\UI\API\Requests\UpdatePropertyreportsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdatePropertyreportsAction extends ParentAction
{
    /**
     * @param UpdatePropertyreportsRequest $request
     * @return Propertyreports
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdatePropertyreportsRequest $request): Propertyreports
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(UpdatePropertyreportsTask::class)->run($data, $request->id);
    }
}
