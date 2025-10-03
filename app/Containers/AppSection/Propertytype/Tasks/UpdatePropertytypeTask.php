<?php

namespace App\Containers\AppSection\Propertytype\Tasks;

use App\Containers\AppSection\Propertytype\Data\Repositories\PropertytypeRepository;
use App\Containers\AppSection\Propertytype\Models\Propertytype;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePropertytypeTask extends ParentTask
{
    public function __construct(
        protected PropertytypeRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(array $data, $id): Propertytype
    {
        try {
            return $this->repository->update($data, $id);
        } catch (ModelNotFoundException) {
            throw new NotFoundException();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
