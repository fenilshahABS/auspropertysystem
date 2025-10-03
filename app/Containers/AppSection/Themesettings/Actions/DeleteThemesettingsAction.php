<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use App\Containers\AppSection\Themesettings\Tasks\DeleteThemesettingsTask;
use App\Containers\AppSection\Themesettings\UI\API\Requests\DeleteThemesettingsRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteThemesettingsAction extends ParentAction
{
    /**
     * @param DeleteThemesettingsRequest $request
     * @return int
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteThemesettingsRequest $request): int
    {
        return app(DeleteThemesettingsTask::class)->run($request->id);
    }
}
