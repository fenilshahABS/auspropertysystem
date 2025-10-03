<?php

namespace App\Containers\AppSection\RentalInvoiceManual\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\RentalInvoiceManual\Actions\CreateRentalInvoiceManualAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\CreateRentalInvoiceTransactionsManualAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\CheckInvoiceNumberAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\SendInvoicePdfonMailAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\SendInvoicePdfonMailMaintainanceAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\DeleteRentalInvoiceManualAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\FindRentalInvoiceManualByIdAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\GetAllRentalInvoiceManualsAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\UpdateRentalInvoiceManualAction;
use App\Containers\AppSection\RentalInvoiceManual\Actions\UpdateRentalInvoiceManualByFieldsAction;
use App\Containers\AppSection\RentalInvoiceManual\Entities\RentalInvoiceManual;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\CreateRentalInvoiceManualRequest;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\DeleteRentalInvoiceManualRequest;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\FindRentalInvoiceManualByIdRequest;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\GetAllRentalInvoiceManualsRequest;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Requests\UpdateRentalInvoiceManualRequest;
use App\Containers\AppSection\RentalInvoiceManual\UI\API\Transformers\RentalInvoiceManualTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    /**
     * @param CreateRentalInvoiceManualRequest $request
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws CreateResourceFailedException
     */
    public function createRentalInvoiceManual(CreateRentalInvoiceManualRequest $request)
    {
        $InputData = new RentalInvoiceManual($request);
        $rentalinvoicemanual = app(CreateRentalInvoiceManualAction::class)->run($request, $InputData);

        return $this->transform($rentalinvoicemanual, RentalInvoiceManualTransformer::class);
    }

    public function SendInvoicePdfonMail(CreateRentalInvoiceManualRequest $request)
    {
        $InputData = new RentalInvoiceManual($request);
        $rentalinvoicemanual = app(SendInvoicePdfonMailAction::class)->run($request, $InputData);
        return $rentalinvoicemanual;
    }

    public function SendInvoicePdfonMailMaintainance(CreateRentalInvoiceManualRequest $request)
    {
        $InputData = new RentalInvoiceManual($request);
        $rentalinvoicemanual = app(SendInvoicePdfonMailMaintainanceAction::class)->run($request, $InputData);
        return $rentalinvoicemanual;
    }

    public function CheckInvoiceNumber(CreateRentalInvoiceManualRequest $request)
    {
        $InputData = new RentalInvoiceManual($request);
        $rentalinvoicemanual = app(CheckInvoiceNumberAction::class)->run($request, $InputData);
        return $rentalinvoicemanual;
    }

    public function CreateRentalInvoiceTransactionsManual(CreateRentalInvoiceManualRequest $request)
    {
        $InputData = new RentalInvoiceManual($request);
        $rentalinvoice = app(CreateRentalInvoiceTransactionsManualAction::class)->run($request, $InputData);

        return $rentalinvoice;
    }

    /**
     * @param FindRentalInvoiceManualByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findRentalInvoiceManualById(FindRentalInvoiceManualByIdRequest $request): array
    {
        $rentalinvoicemanual = app(FindRentalInvoiceManualByIdAction::class)->run($request);

        return $this->transform($rentalinvoicemanual, RentalInvoiceManualTransformer::class);
    }

    /**
     * @param GetAllRentalInvoiceManualsRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function getAllRentalInvoiceManuals(GetAllRentalInvoiceManualsRequest $request)
    {
        $InputData = new RentalInvoiceManual($request);
        $rentalinvoicemanuals = app(GetAllRentalInvoiceManualsAction::class)->run($request, $InputData);

        return $rentalinvoicemanuals;
    }

    /**
     * @param UpdateRentalInvoiceManualRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws UpdateResourceFailedException
     */
    public function updateRentalInvoiceManual(UpdateRentalInvoiceManualRequest $request)
    {
        $InputData  = new RentalInvoiceManual($request);
        $rentalinvoicemanual = app(UpdateRentalInvoiceManualAction::class)->run($request, $InputData);
        return $this->transform($rentalinvoicemanual, RentalInvoiceManualTransformer::class);
    }

    public function UpdateRentalInvoiceManualByFields(UpdateRentalInvoiceManualRequest $request)
    {
        $InputData  = new RentalInvoiceManual($request);
        $rentalinvoicemanual = app(UpdateRentalInvoiceManualByFieldsAction::class)->run($request, $InputData);
        return $this->transform($rentalinvoicemanual, RentalInvoiceManualTransformer::class);
    }

    /**
     * @param DeleteRentalInvoiceManualRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deleteRentalInvoiceManual(DeleteRentalInvoiceManualRequest $request)
    {
        $rentalinvoicemanual =   app(DeleteRentalInvoiceManualAction::class)->run($request);

        return $rentalinvoicemanual;
    }
}
