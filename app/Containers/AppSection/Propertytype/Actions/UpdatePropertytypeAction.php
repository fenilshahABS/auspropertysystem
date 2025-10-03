<?php

namespace App\Containers\AppSection\Propertytype\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Containers\AppSection\Propertytype\Tasks\UpdatePropertytypeTask;
use App\Containers\AppSection\Propertytype\UI\API\Requests\UpdatePropertytypeRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdatePropertytypeAction extends ParentAction
{
    /**
     * @param UpdatePropertytypeRequest $request
     * @return Propertytype
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdatePropertytypeRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            'type' => $InputData->getType()
        ]);
        $data = array_filter($data);

        return app(UpdatePropertytypeTask::class)->run($data, $request->id);
    }
}
