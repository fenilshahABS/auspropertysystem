<?php

namespace App\Containers\AppSection\Expensemanagement\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Expensemanagement\Actions\CreateExpensemanagementAction;
use App\Containers\AppSection\Expensemanagement\Actions\DeleteExpensemanagementAction;
use App\Containers\AppSection\Expensemanagement\Actions\FindExpensemanagementByIdAction;
use App\Containers\AppSection\Expensemanagement\Actions\GetAllExpensemanagementsAction;
use App\Containers\AppSection\Expensemanagement\Actions\GetAllExpensemanagementsBySearchAction;
use App\Containers\AppSection\Expensemanagement\Actions\UpdateExpensemanagementAction;
use App\Containers\AppSection\Expensemanagement\Actions\UpdateExpensemanagementByFieldsAction;
use App\Containers\AppSection\Expensemanagement\Entities\Expensemanagement;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\CreateExpensemanagementRequest;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\DeleteExpensemanagementRequest;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\FindExpensemanagementByIdRequest;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\GetAllExpensemanagementsRequest;
use App\Containers\AppSection\Expensemanagement\UI\API\Requests\UpdateExpensemanagementRequest;
use App\Containers\AppSection\Expensemanagement\UI\API\Transformers\ExpensemanagementTransformer;
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
     * @param CreateExpensemanagementRequest $request
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws CreateResourceFailedException
     */
    public function createExpensemanagement(CreateExpensemanagementRequest $request)
    {
        $InputData = new Expensemanagement($request);
        $expensemanagement = app(CreateExpensemanagementAction::class)->run($request, $InputData);

        return $this->transform($expensemanagement, ExpensemanagementTransformer::class);
    }

    /**
     * @param FindExpensemanagementByIdRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function findExpensemanagementById(FindExpensemanagementByIdRequest $request)
    {
        $expensemanagement = app(FindExpensemanagementByIdAction::class)->run($request);

        return $this->transform($expensemanagement, ExpensemanagementTransformer::class);
    }

    /**
     * @param GetAllExpensemanagementsRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function getAllExpensemanagements(GetAllExpensemanagementsRequest $request): array
    {
        $expensemanagements = app(GetAllExpensemanagementsAction::class)->run($request);

        return $this->transform($expensemanagements, ExpensemanagementTransformer::class);
    }

    public function getAllExpensemanagementsBySearch(GetAllExpensemanagementsRequest $request): array
    {
        $InputData = new Expensemanagement($request);
        $expensemanagements = app(GetAllExpensemanagementsBySearchAction::class)->run($request, $InputData);

        return $expensemanagements;
    }

    /**
     * @param UpdateExpensemanagementRequest $request
     * @return array
     * @throws InvalidTransformerException
     * @throws UpdateResourceFailedException
     */
    public function updateExpensemanagement(UpdateExpensemanagementRequest $request): array
    {
        $InputData = new Expensemanagement($request);
        $expensemanagement = app(UpdateExpensemanagementAction::class)->run($request, $InputData);

        return $this->transform($expensemanagement, ExpensemanagementTransformer::class);
    }

    public function updateExpensemanagementByFields(UpdateExpensemanagementRequest $request): array
    {
        $InputData = new Expensemanagement($request);
        $expensemanagement = app(UpdateExpensemanagementByFieldsAction::class)->run($request, $InputData);

        return $expensemanagement;
    }

    /**
     * @param DeleteExpensemanagementRequest $request
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function deleteExpensemanagement(DeleteExpensemanagementRequest $request)
    {
        $expensemanagement = app(DeleteExpensemanagementAction::class)->run($request);
        return $expensemanagement;
    }
}
