<?php

namespace App\Containers\AppSection\Workermaster\UI\API\Transformers;

use App\Containers\AppSection\Workermaster\Models\Workermaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class WorkermasterTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Workermaster $workermaster): array
    {
        $response = [
          'object' => $workermaster->getResourceKey(),
          'id' => $workermaster->getHashedKey(),
          'worker_name' => $workermaster->worker_name,
          'worker_mobile_no' => $workermaster->worker_mobile_no,
          'worker_email' => $workermaster->worker_email,
          'worker_address' => $workermaster->worker_address,
          'worker_city' => $workermaster->worker_city,
          'worker_state' => $workermaster->worker_state,
          'worker_zip_code' => $workermaster->worker_zip_code,
          'worker_country' => $workermaster->worker_country,
          'created_at' => $workermaster->created_at,
          'updated_at' => $workermaster->updated_at,
        ];

        return $response;
    }
}
