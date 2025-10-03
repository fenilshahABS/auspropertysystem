<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Themesettings\Tasks\CreateThemesettingsTask;
use App\Containers\AppSection\Themesettings\UI\API\Requests\CreateThemesettingsRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateThemesettingsAction extends ParentAction
{
    /**
     * @param CreateThemesettingsRequest $request
     * @return Themesettings
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreateThemesettingsRequest $request): Themesettings
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return app(CreateThemesettingsTask::class)->run($data);
    }
}
