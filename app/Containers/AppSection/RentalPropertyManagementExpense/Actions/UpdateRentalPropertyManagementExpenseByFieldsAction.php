<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\RentalPropertyManagementExpense\Models\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Tasks\UpdateRentalPropertyManagementExpenseByFieldsTask;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\UpdateRentalPropertyManagementExpenseRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateRentalPropertyManagementExpenseByFieldsAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateRentalPropertyManagementExpenseRequest $request, $InputData)
    {
        return app(UpdateRentalPropertyManagementExpenseByFieldsTask::class)->run($InputData, $request->id);
    }
}
