<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Themesettings\Tasks\FindThemesettingsByIdTask;
use App\Containers\AppSection\Themesettings\UI\API\Requests\FindThemesettingsByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindThemesettingsByIdAction extends ParentAction
{

    public function run(FindThemesettingsByIdRequest $request)
    {
        return app(FindThemesettingsByIdTask::class)->run($request->id);
    }
}
