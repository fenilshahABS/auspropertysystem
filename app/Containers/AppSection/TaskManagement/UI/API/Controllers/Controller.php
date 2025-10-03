<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\TaskManagement\Actions\CreateTaskManagementAction;
use App\Containers\AppSection\TaskManagement\Actions\DeleteTaskManagementAction;
use App\Containers\AppSection\TaskManagement\Actions\FindTaskManagementByIdAction;
use App\Containers\AppSection\TaskManagement\Actions\GetAllTaskManagementsAction;
use App\Containers\AppSection\TaskManagement\Actions\UpdateTaskManagementAction;
use App\Containers\AppSection\TaskManagement\Actions\UpdateTaskManagementByFieldsAction;
use App\Containers\AppSection\TaskManagement\Actions\CreateTaskManagementCustomNotificationAction;
use App\Containers\AppSection\TaskManagement\Actions\DeleteTaskManagementCustomNotificationAction;
use App\Containers\AppSection\TaskManagement\Entities\TaskManagement;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\CreateTaskManagementRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\DeleteTaskManagementRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\FindTaskManagementByIdRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\GetAllTaskManagementsRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\UpdateTaskManagementRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Transformers\TaskManagementTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{

    public function createTaskManagement(CreateTaskManagementRequest $request)
    {
        $InputData = new TaskManagement($request);
        $taskmanagement = app(CreateTaskManagementAction::class)->run($request, $InputData);
        return $this->transform($taskmanagement, TaskManagementTransformer::class);
    }

    public function CreateTaskManagementCustomNotification(CreateTaskManagementRequest $request)
    {
        $InputData = new TaskManagement($request);
        $taskmanagement = app(CreateTaskManagementCustomNotificationAction::class)->run($request, $InputData);
        return $taskmanagement;
    }

    public function findTaskManagementById(FindTaskManagementByIdRequest $request)
    {
        $taskmanagement = app(FindTaskManagementByIdAction::class)->run($request);

        return $this->transform($taskmanagement, TaskManagementTransformer::class);
    }


    public function getAllTaskManagements(FindTaskManagementByIdRequest $request)
    {
        $taskmanagements = app(GetAllTaskManagementsAction::class)->run($request);
        return $taskmanagements;
    }


    public function updateTaskManagement(UpdateTaskManagementRequest $request)
    {
        $InputData = new TaskManagement($request);
        $taskmanagement = app(UpdateTaskManagementAction::class)->run($request, $InputData);
        return $this->transform($taskmanagement, TaskManagementTransformer::class);
    }


    public function UpdateTaskManagementByFields(UpdateTaskManagementRequest $request)
    {
        $InputData = new TaskManagement($request);
        $taskmanagement = app(UpdateTaskManagementByFieldsAction::class)->run($request, $InputData);
        return $this->transform($taskmanagement, TaskManagementTransformer::class);
    }

    public function deleteTaskManagement(DeleteTaskManagementRequest $request)
    {
        $taskmanagement = app(DeleteTaskManagementAction::class)->run($request);

        return $taskmanagement;
    }
    public function DeleteTaskManagementCustomNotification(DeleteTaskManagementRequest $request)
    {
        $taskmanagement = app(DeleteTaskManagementCustomNotificationAction::class)->run($request);

        return $taskmanagement;
    }
}
