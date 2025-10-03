<?php

namespace App\Containers\AppSection\RentalPropertyManagement\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\RentalPropertyManagement\Tasks\UpdateRentalPropertyManagementByFieldsTask;
use App\Containers\AppSection\RentalPropertyManagement\UI\API\Requests\UpdateRentalPropertyManagementRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateRentalPropertyManagementByFieldsAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateRentalPropertyManagementRequest $request, $InputData)
    {

        return app(UpdateRentalPropertyManagementByFieldsTask::class)->run($InputData, $request->id);
    }
}
