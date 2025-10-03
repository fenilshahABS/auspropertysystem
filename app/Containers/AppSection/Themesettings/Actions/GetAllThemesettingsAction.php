<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Themesettings\Tasks\GetAllThemesettingsTask;
use App\Containers\AppSection\Themesettings\UI\API\Requests\GetAllThemesettingsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllThemesettingsAction extends ParentAction
{
    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(GetAllThemesettingsRequest $request): mixed
    {
        return app(GetAllThemesettingsTask::class)->run();
    }
}
