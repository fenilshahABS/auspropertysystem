<?php

namespace App\Containers\AppSection\Propertytype\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Containers\AppSection\Propertytype\Tasks\CreatePropertytypeTask;
use App\Containers\AppSection\Propertytype\UI\API\Requests\CreatePropertytypeRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreatePropertytypeAction extends ParentAction
{
    /**
     * @param CreatePropertytypeRequest $request
     * @return Propertytype
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreatePropertytypeRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            'type' => $InputData->getType(),
            'is_active' => 1
        ]);

        return app(CreatePropertytypeTask::class)->run($data);
    }
}
