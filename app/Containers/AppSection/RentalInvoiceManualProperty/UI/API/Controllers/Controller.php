<?php

namespace App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\CreateRentalInvoiceManualPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\CreateRentalInvoiceTransactionsManualPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\CheckInvoiceNumberPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\SendInvoicePdfonMailPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\DeleteRentalInvoiceManualPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\FindRentalInvoiceManualByIdPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\GetAllRentalInvoiceManualsPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\UpdateRentalInvoiceManualPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Actions\UpdateRentalInvoiceManualByFieldsPropertyAction;
use App\Containers\AppSection\RentalInvoiceManualProperty\Entities\RentalInvoiceManualProperty;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\CreateRentalInvoiceManualPropertyRequest;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\DeleteRentalInvoiceManualPropertyRequest;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\FindRentalInvoiceManualPropertyByIdRequest;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\GetAllRentalInvoiceManualsPropertyRequest;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Requests\UpdateRentalInvoiceManualPropertyRequest;
use App\Containers\AppSection\RentalInvoiceManualProperty\UI\API\Transformers\RentalInvoiceManualPropertyTransformer;
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
    public function createRentalInvoiceManualProperty(CreateRentalInvoiceManualPropertyRequest $request)
    {
        $InputData = new RentalInvoiceManualProperty($request);
        $rentalinvoicemanual = app(CreateRentalInvoiceManualPropertyAction::class)->run($request, $InputData);

        return $this->transform($rentalinvoicemanual, RentalInvoiceManualPropertyTransformer::class);
    }

    public function SendInvoicePdfonMailProperty(CreateRentalInvoiceManualPropertyRequest $request)
    {
        $InputData = new RentalInvoiceManualProperty($request);
        $rentalinvoicemanual = app(SendInvoicePdfonMailPropertyAction::class)->run($request, $InputData);
        return $rentalinvoicemanual;
    }

    public function CheckInvoiceNumberProperty(CreateRentalInvoiceManualPropertyRequest $request)
    {
        $InputData = new RentalInvoiceManualProperty($request);
        $rentalinvoicemanual = app(CheckInvoiceNumberPropertyAction::class)->run($request, $InputData);
        return $rentalinvoicemanual;
    }

    public function CreateRentalInvoiceTransactionsManualProperty(CreateRentalInvoiceManualPropertyRequest $request)
    {
        $InputData = new RentalInvoiceManualProperty($request);
        $rentalinvoice = app(CreateRentalInvoiceTransactionsManualPropertyAction::class)->run($request, $InputData);

        return $rentalinvoice;
    }

    /**
     * @param FindRentalInvoiceManualByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findRentalInvoiceManualByIdProperty(FindRentalInvoiceManualPropertyByIdRequest $request): array
    {
        $rentalinvoicemanual = app(FindRentalInvoiceManualByIdPropertyAction::class)->run($request);

        return $this->transform($rentalinvoicemanual, RentalInvoiceManualPropertyTransformer::class);
    }

    /**
     * @param GetAllRentalInvoiceManualsRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function getAllRentalInvoiceManualsProperty(GetAllRentalInvoiceManualsPropertyRequest $request)
    {
        $InputData = new RentalInvoiceManualProperty($request);
        $rentalinvoicemanuals = app(GetAllRentalInvoiceManualsPropertyAction::class)->run($request, $InputData);

        return $rentalinvoicemanuals;
    }

    /**
     * @param UpdateRentalInvoiceManualRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws UpdateResourceFailedException
     */
    public function updateRentalInvoiceManualProperty(UpdateRentalInvoiceManualPropertyRequest $request)
    {
        $InputData  = new RentalInvoiceManualProperty($request);
        $rentalinvoicemanual = app(UpdateRentalInvoiceManualPropertyAction::class)->run($request, $InputData);
        return $this->transform($rentalinvoicemanual, RentalInvoiceManualPropertyTransformer::class);
    }

    public function UpdateRentalInvoiceManualByFieldsProperty(UpdateRentalInvoiceManualPropertyRequest $request)
    {
        $InputData  = new RentalInvoiceManualProperty($request);
        $rentalinvoicemanual = app(UpdateRentalInvoiceManualByFieldsPropertyAction::class)->run($request, $InputData);
        return $this->transform($rentalinvoicemanual, RentalInvoiceManualPropertyTransformer::class);
    }

    /**
     * @param DeleteRentalInvoiceManualRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deleteRentalInvoiceManualProperty(DeleteRentalInvoiceManualPropertyRequest $request)
    {
        $rentalinvoicemanual =   app(DeleteRentalInvoiceManualPropertyAction::class)->run($request);

        return $rentalinvoicemanual;
    }
}
