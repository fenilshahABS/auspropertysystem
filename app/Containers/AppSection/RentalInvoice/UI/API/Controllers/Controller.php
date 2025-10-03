<?php

namespace App\Containers\AppSection\RentalInvoice\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\RentalInvoice\Actions\CreateRentalInvoiceAction;
use App\Containers\AppSection\RentalInvoice\Actions\CreateRentalInvoiceTransactionsAction;
use App\Containers\AppSection\RentalInvoice\Actions\DeleteRentalInvoiceAction;
use App\Containers\AppSection\RentalInvoice\Actions\DeleteRentalInvoiceLateFeesAction;
use App\Containers\AppSection\RentalInvoice\Actions\FindRentalInvoiceByIdAction;
use App\Containers\AppSection\RentalInvoice\Actions\GetAllRentalInvoicesAction;
use App\Containers\AppSection\RentalInvoice\Actions\GetAllRentalInvoicesPaginationAction;
use App\Containers\AppSection\RentalInvoice\Actions\PropertyOwnerInvoicesAction;
use App\Containers\AppSection\RentalInvoice\Actions\UpdateRentalInvoiceAction;
use App\Containers\AppSection\RentalInvoice\Actions\UpdateRentalInvoiceByFieldsAction;
use App\Containers\AppSection\RentalInvoice\Actions\UpdateRentalOwnerInvoiceAction;
use App\Containers\AppSection\RentalInvoice\Actions\UpdateRentalInvoiceLateFeesAction;
use App\Containers\AppSection\RentalInvoice\Entities\RentalInvoice;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\CreateRentalInvoiceRequest;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\DeleteRentalInvoiceRequest;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\FindRentalInvoiceByIdRequest;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\GetAllRentalInvoicesRequest;
use App\Containers\AppSection\RentalInvoice\UI\API\Requests\UpdateRentalInvoiceRequest;
use App\Containers\AppSection\RentalInvoice\UI\API\Transformers\RentalInvoiceTransformer;
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
     * @param CreateRentalInvoiceRequest $request
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws CreateResourceFailedException
     */
    public function createRentalInvoice(CreateRentalInvoiceRequest $request): JsonResponse
    {
        $rentalinvoice = app(CreateRentalInvoiceAction::class)->run($request);

        return $this->created($this->transform($rentalinvoice, RentalInvoiceTransformer::class));
    }

    public function CreateRentalInvoiceTransactions(CreateRentalInvoiceRequest $request)
    {
        $InputData = new RentalInvoice($request);
        $rentalinvoice = app(CreateRentalInvoiceTransactionsAction::class)->run($request, $InputData);

        return $rentalinvoice;
    }

    /**
     * @param FindRentalInvoiceByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findRentalInvoiceById(FindRentalInvoiceByIdRequest $request)
    {
        $rentalinvoice = app(FindRentalInvoiceByIdAction::class)->run($request);

        return $rentalinvoice;
    }

    /**
     * @param GetAllRentalInvoicesRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function getAllRentalInvoices(GetAllRentalInvoicesRequest $request): array
    {
        $rentalinvoices = app(GetAllRentalInvoicesAction::class)->run($request);
        return $this->transform($rentalinvoices, RentalInvoiceTransformer::class);
    }

    public function GetAllRentalInvoicesPagination(GetAllRentalInvoicesRequest $request)
    {
        $InputData = new RentalInvoice($request);
        $rentalinvoices = app(GetAllRentalInvoicesPaginationAction::class)->run($request, $InputData);
        return $rentalinvoices;
    }

    public function PropertyOwnerInvoices(GetAllRentalInvoicesRequest $request)
    {
        $InputData = new RentalInvoice($request);
        $rentalinvoices = app(PropertyOwnerInvoicesAction::class)->run($request, $InputData);
        return $rentalinvoices;
    }

    /**
     * @param UpdateRentalInvoiceRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws UpdateResourceFailedException
     */
    public function updateRentalInvoice(UpdateRentalInvoiceRequest $request)
    {
        $InputData = new RentalInvoice($request);
        $rentalinvoice = app(UpdateRentalInvoiceAction::class)->run($request, $InputData);
        return $rentalinvoice;
    }

    public function UpdateRentalInvoiceLateFees(UpdateRentalInvoiceRequest $request)
    {
        $InputData = new RentalInvoice($request);
        $rentalinvoice = app(UpdateRentalInvoiceLateFeesAction::class)->run($request, $InputData);
        return $rentalinvoice;
    }

    public function UpdateRentalOwnerInvoice(UpdateRentalInvoiceRequest $request)
    {
        $InputData = new RentalInvoice($request);
        $rentalinvoice = app(UpdateRentalOwnerInvoiceAction::class)->run($request, $InputData);
        return $rentalinvoice;
    }


    public function UpdateRentalInvoiceByFields(UpdateRentalInvoiceRequest $request)
    {
        $InputData = new RentalInvoice($request);
        $rentalinvoice = app(UpdateRentalInvoiceByFieldsAction::class)->run($request, $InputData);
        return $rentalinvoice;
    }

    /**
     * @param DeleteRentalInvoiceRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deleteRentalInvoice(DeleteRentalInvoiceRequest $request): JsonResponse
    {
        app(DeleteRentalInvoiceAction::class)->run($request);

        return $this->noContent();
    }
    public function DeleteRentalInvoiceLateFees(DeleteRentalInvoiceRequest $request)
    {
        $rentalinvoice = app(DeleteRentalInvoiceLateFeesAction::class)->run($request);
        return $rentalinvoice;
    }
}
