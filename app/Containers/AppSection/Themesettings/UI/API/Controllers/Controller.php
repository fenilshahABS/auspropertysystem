<?php

namespace App\Containers\AppSection\Themesettings\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Themesettings\Actions\CreateThemesettingsAction;
use App\Containers\AppSection\Themesettings\Actions\DeleteThemesettingsAction;
use App\Containers\AppSection\Themesettings\Actions\FindThemesettingsByIdAction;
use App\Containers\AppSection\Themesettings\Actions\FindThemesettingsByIdWithoutAuthAction;
use App\Containers\AppSection\Themesettings\Actions\GetAllThemesettingsAction;
use App\Containers\AppSection\Themesettings\Actions\UpdateThemesettingsAction;
use App\Containers\AppSection\Themesettings\UI\API\Requests\CreateThemesettingsRequest;
use App\Containers\AppSection\Themesettings\UI\API\Requests\DeleteThemesettingsRequest;
use App\Containers\AppSection\Themesettings\UI\API\Requests\FindThemesettingsByIdRequest;
use App\Containers\AppSection\Themesettings\UI\API\Requests\GetAllThemesettingsRequest;
use App\Containers\AppSection\Themesettings\UI\API\Requests\UpdateThemesettingsRequest;
use App\Containers\AppSection\Themesettings\UI\API\Transformers\ThemesettingsTransformer;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\AppSection\Themesettings\Entities\Themesettings;

class Controller extends ApiController
{

    public function createThemesettings(CreateThemesettingsRequest $request)
    {
        $themesettings = app(CreateThemesettingsAction::class)->run($request);
        return $this->created($this->transform($themesettings, ThemesettingsTransformer::class));
    }


    public function findThemesettingsById(FindThemesettingsByIdRequest $request)
    {

        $themesettings = app(FindThemesettingsByIdAction::class)->run($request);
        return $themesettings;
    }


    public function findThemesettingsByIdWithoutAuth(FindThemesettingsByIdRequest $request)
    {

        $themesettings = app(FindThemesettingsByIdWithoutAuthAction::class)->run($request);
        return $themesettings;
    }


    public function getAllThemesettings(GetAllThemesettingsRequest $request)
    {
        $themesettings = app(GetAllThemesettingsAction::class)->run($request);

        return $this->transform($themesettings, ThemesettingsTransformer::class);
    }


    public function updateThemesettings(UpdateThemesettingsRequest $request)
    {

        $InputData = new Themesettings($request);
        $themesettings = app(UpdateThemesettingsAction::class)->run($request, $InputData);
        return $themesettings;
    }


    public function deleteThemesettings(DeleteThemesettingsRequest $request)
    {
        app(DeleteThemesettingsAction::class)->run($request);

        return $this->noContent();
    }
}
