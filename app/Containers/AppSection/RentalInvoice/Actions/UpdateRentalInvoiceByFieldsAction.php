<?php

namespace App\Containers\AppSection\RentalInvoice\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\RentalInvoice\Models\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\Tasks\UpdateRentalInvoiceByFieldsTask;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\UpdateRentalInvoiceRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateRentalInvoiceByFieldsAction extends ParentAction
{

    public function run(UpdateRentalInvoiceRequest $request, $InputData)
    {


        return app(UpdateRentalInvoiceByFieldsTask::class)->run($InputData, $request->id);
    }
}
