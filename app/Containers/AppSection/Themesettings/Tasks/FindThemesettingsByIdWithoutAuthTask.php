<?php

namespace App\Containers\AppSection\Themesettings\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Themesettings\Data\Repositories\ThemesettingsRepository;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Apiato\Core\Traits\HashIdTrait;

class FindThemesettingsByIdWithoutAuthTask extends ParentTask
{
    use HashIdTrait;
    protected ThemesettingsRepository $repository;
    public function __construct(ThemesettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            $returnData = array();
            $image_api_url = Themesettings::select('image_api_url')->where('id', 1)->first();
            $getData = Themesettings::where('id', $id)->first();
            if ($getData != "" && $getData != null) {
                $returnData['message'] = "Data Found";
                $returnData['data']['objects'] = 'pro_master_theme_settings';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] = $getData->name;
                $returnData['data']['white_logo'] = ($getData->white_logo) ? $image_api_url->image_api_url . $getData->white_logo : "";
                $returnData['data']['black_logo'] = ($getData->black_logo) ? $image_api_url->image_api_url . $getData->black_logo : "";

                $returnData['data']['favicon'] = ($getData->favicon) ? $image_api_url->image_api_url . $getData->favicon : "";
                $returnData['data']['description'] = $getData->description;
            } else {
                $returnData = [
                    'message' => "No Data Found",
                    'object' => "pro_master_theme_settings",
                    'data' => [],
                ];
            }
            $returnData['message'] = "Data Found";
            $returnData['data']['objects'] = "pro_master_theme_settings";
            // $returnData['data'] =  $this->repository->find($id);
            return $returnData;
        } catch (Exception $e) {
            return [
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'pro_master_theme_settings',
                'data' => [],
            ];
        }
    }
}
