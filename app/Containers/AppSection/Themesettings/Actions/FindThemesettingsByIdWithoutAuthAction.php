<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Themesettings\Tasks\FindThemesettingsByIdWithoutAuthTask;
use App\Containers\AppSection\Themesettings\UI\API\Requests\FindThemesettingsByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindThemesettingsByIdWithoutAuthAction extends ParentAction
{

    public function run(FindThemesettingsByIdRequest $request)
    {
        return app(FindThemesettingsByIdWithoutAuthTask::class)->run($request->id);
    }
}
