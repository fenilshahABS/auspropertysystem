<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\RentalPropertyManagementExpense\Entities\RentalPropertyManagementExpense;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\CreateRentalPropertyManagementExpenseAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\DeleteRentalPropertyManagementExpenseAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\DeleteRentalPropertyManagementWorkerDetailsAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\DeleteRentalPropertyManagementExpenseDetailsAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\FindRentalPropertyManagementExpenseByIdAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\GetAllRentalPropertyManagementExpensesAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\GetAllRentalPropertyManagementExpensesInvoiceAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\GetAllRentalPropertyManagementExpensesBySearchAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\GetAllRentalPropertyManagementExpensesByOwnerIdAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\GetAllRentalPropertyManagementExpensesByWorkerIdAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\UpdateRentalPropertyManagementExpenseAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\UpdateRentalPropertyManagementWorkersAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\Actions\UpdateRentalPropertyManagementExpenseByFieldsAction;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\CreateRentalPropertyManagementExpenseRequest;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\DeleteRentalPropertyManagementExpenseRequest;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\FindRentalPropertyManagementExpenseByIdRequest;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\GetAllRentalPropertyManagementExpensesRequest;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Requests\UpdateRentalPropertyManagementExpenseRequest;
use App\Containers\AppSection\RentalPropertyManagementExpense\UI\API\Transformers\RentalPropertyManagementExpenseTransformer;
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
     * @param CreateRentalPropertyManagementExpenseRequest $request
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws CreateResourceFailedException
     */
    public function createRentalPropertyManagementExpense(CreateRentalPropertyManagementExpenseRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpense = app(CreateRentalPropertyManagementExpenseAction::class)->run($request, $InputData);
        return $this->transform($rentalpropertymanagementexpense, RentalPropertyManagementExpenseTransformer::class);
    }


    public function findRentalPropertyManagementExpenseById(FindRentalPropertyManagementExpenseByIdRequest $request)
    {
        $rentalpropertymanagementexpense = app(FindRentalPropertyManagementExpenseByIdAction::class)->run($request);
        return $this->transform($rentalpropertymanagementexpense, RentalPropertyManagementExpenseTransformer::class);
    }

    public function getAllRentalPropertyManagementExpensesInvoice(FindRentalPropertyManagementExpenseByIdRequest $request)
    {
        $rentalpropertymanagementexpenses = app(GetAllRentalPropertyManagementExpensesInvoiceAction::class)->run($request);
        return $rentalpropertymanagementexpenses;
    }

    public function getAllRentalPropertyManagementExpenses(GetAllRentalPropertyManagementExpensesRequest $request)
    {
        $rentalpropertymanagementexpenses = app(GetAllRentalPropertyManagementExpensesAction::class)->run($request);
        return $rentalpropertymanagementexpenses;
    }

    public function GetAllRentalPropertyManagementExpensesBySearch(GetAllRentalPropertyManagementExpensesRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpenses = app(GetAllRentalPropertyManagementExpensesBySearchAction::class)->run($request, $InputData);
        return $rentalpropertymanagementexpenses;
    }


    public function GetAllRentalPropertyManagementExpensesByOwnerId(GetAllRentalPropertyManagementExpensesRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpenses = app(GetAllRentalPropertyManagementExpensesByOwnerIdAction::class)->run($request, $InputData);
        return $rentalpropertymanagementexpenses;
    }

    public function GetAllRentalPropertyManagementExpensesByWorkerId(GetAllRentalPropertyManagementExpensesRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpenses = app(GetAllRentalPropertyManagementExpensesByWorkerIdAction::class)->run($request, $InputData);
        return $rentalpropertymanagementexpenses;
    }

    public function updateRentalPropertyManagementExpense(UpdateRentalPropertyManagementExpenseRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpense = app(UpdateRentalPropertyManagementExpenseAction::class)->run($request, $InputData);
        return $this->transform($rentalpropertymanagementexpense, RentalPropertyManagementExpenseTransformer::class);
    }

    public function updateRentalPropertyManagementWorkers(UpdateRentalPropertyManagementExpenseRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpense = app(UpdateRentalPropertyManagementWorkersAction::class)->run($request, $InputData);
        return $rentalpropertymanagementexpense;
    }

    public function UpdateRentalPropertyManagementExpenseByFields(UpdateRentalPropertyManagementExpenseRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpense = app(UpdateRentalPropertyManagementExpenseByFieldsAction::class)->run($request, $InputData);
        return $this->transform($rentalpropertymanagementexpense, RentalPropertyManagementExpenseTransformer::class);
    }

    public function deleteRentalPropertyManagementExpense(DeleteRentalPropertyManagementExpenseRequest $request)
    {
        $rentalpropertymanagementexpense =  app(DeleteRentalPropertyManagementExpenseAction::class)->run($request);
        return $rentalpropertymanagementexpense;
    }
    public function DeleteRentalPropertyManagementExpenseDetails(DeleteRentalPropertyManagementExpenseRequest $request)
    {
        $rentalpropertymanagementexpense =  app(DeleteRentalPropertyManagementExpenseDetailsAction::class)->run($request);
        return $rentalpropertymanagementexpense;
    }
    public function DeleteRentalPropertyManagementWorkerDetails(GetAllRentalPropertyManagementExpensesRequest $request)
    {
        $InputData = new RentalPropertyManagementExpense($request);
        $rentalpropertymanagementexpense =  app(DeleteRentalPropertyManagementWorkerDetailsAction::class)->run($request,$InputData);
        return $rentalpropertymanagementexpense;
    }
}
