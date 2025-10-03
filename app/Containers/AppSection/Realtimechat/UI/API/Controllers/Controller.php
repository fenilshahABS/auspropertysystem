<?php

namespace App\Containers\AppSection\Realtimechat\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Realtimechat\Actions\CreateRealtimechatAction;
use App\Containers\AppSection\Realtimechat\Actions\DeleteRealtimechatAction;
use App\Containers\AppSection\Realtimechat\Actions\RealtimechatCountsAction;
use App\Containers\AppSection\Realtimechat\Actions\GetAllRealtimechatsAction;
use App\Containers\AppSection\Realtimechat\Actions\UpdateRealtimechatAction;
use App\Containers\AppSection\Realtimechat\Entities\Realtimechat;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\CreateRealtimechatRequest;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\DeleteRealtimechatRequest;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\FindRealtimechatByIdRequest;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\GetAllRealtimechatsRequest;
use App\Containers\AppSection\Realtimechat\UI\API\Requests\UpdateRealtimechatRequest;
use App\Containers\AppSection\Realtimechat\UI\API\Transformers\RealtimechatTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{

    public function createRealtimechat(CreateRealtimechatRequest $request)
    {
        $InputData = new Realtimechat($request);
        $realtimechat = app(CreateRealtimechatAction::class)->run($request, $InputData);

        return $this->transform($realtimechat, RealtimechatTransformer::class);
    }


    public function RealtimechatCounts(GetAllRealtimechatsRequest $request)
    {
        $InputData = new Realtimechat($request);
        $realtimechat = app(RealtimechatCountsAction::class)->run($request, $InputData);
        return $realtimechat;
    }

    public function getAllRealtimechats(GetAllRealtimechatsRequest $request)
    {
        $InputData = new Realtimechat($request);
        $realtimechats = app(GetAllRealtimechatsAction::class)->run($request, $InputData);

        return $realtimechats;
    }

    public function updateRealtimechat(UpdateRealtimechatRequest $request)
    {
        $InputData = new Realtimechat($request);
        $realtimechat = app(UpdateRealtimechatAction::class)->run($request, $InputData);

        return $realtimechat;
    }

    public function deleteRealtimechat(DeleteRealtimechatRequest $request): JsonResponse
    {
        app(DeleteRealtimechatAction::class)->run($request);

        return $this->noContent();
    }
}
