<?php

namespace App\Containers\AppSection\Rolemaster\Tasks;

use App\Containers\AppSection\Rolemaster\Data\Repositories\RolemasterRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Rolemaster\Models\Rolemaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRolemasterTask extends ParentTask
{
    public function __construct(
        protected RolemasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Rolemaster::where('id', $id)->first();
            if ($getData != null) {
                Rolemaster::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfuly',
                    'object' => 'Role Master',
                    'data' => [],
                ];
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Role Master',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Role Master',
                'data' => [],
            ];
        }
    }
}
