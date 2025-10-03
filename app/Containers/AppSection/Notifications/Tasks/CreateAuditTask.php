<?php

namespace App\Containers\AppSection\Notifications\Tasks;

use App\Containers\AppSection\Notifications\Data\Repositories\NotificationsRepository;
use App\Containers\AppSection\Notifications\Models\Notifications;
use App\Containers\AppSection\Roles\Models\Roles;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use OwenIt\Auditing\Models\Audit;

class CreateAuditTask extends ParentTask
{
    public function __construct(
        protected NotificationsRepository $repository
    ) {
    }

    public function run($data, $flag, $getData, $data_before_update)
    {
        try {
            $getUser = Auth::user();
            $role_id = $getUser->role_id;
            if ($flag == 'create') {
                $audit = new Audit();
                $audit->user_id = Auth::id() ?? "";
                $audit->role_who_did = Roles::find($role_id)->name ?? "";
                $audit->user_type =  get_class($getData);
                $audit->event = 'created';
                $audit->auditable_type =  get_class($getData);
                $audit->auditable_id = $getData->id;
                $audit->old_values = null;
                $audit->new_values = json_encode($getData->getAttributes());
                $audit->url = Request::fullUrl();
                $audit->ip_address = Request::ip();
                $audit->user_agent = Request::userAgent();
                $audit->save();
            } elseif ($flag == 'update') {
                $audit = new Audit;
                $audit->user_id = Auth::id() ?? "";
                $audit->role_who_did = Roles::find($role_id)->name ?? "";
                $audit->user_type =  get_class($getData);
                $audit->event = 'updated';
                $audit->auditable_type = get_class($getData);
                $audit->auditable_id = $getData->id;
                $audit->old_values = $data_before_update;
                $audit->new_values = json_encode($data);
                $audit->url = Request::fullUrl();
                $audit->ip_address = Request::ip();
                $audit->user_agent = Request::userAgent();
                $audit->save();
            } elseif ($flag == "delete") {
                $audit = new Audit;
                $audit->user_id = Auth::id() ?? "";
                $audit->role_who_did = Roles::find($role_id)->name ?? "";
                $audit->user_type = get_class($getData);
                $audit->event = 'deleted';
                $audit->auditable_type = get_class($getData);
                $audit->auditable_id = $getData->id;
                $audit->old_values = json_encode($getData);
                $audit->new_values = null;
                $audit->url = Request::fullUrl();
                $audit->ip_address = Request::ip();
                $audit->user_agent = Request::userAgent();
                $audit->save();
            } // elseif ($flag == "list all") {
            //     $audit = new Audit;
            //     $audit->user_id = Auth::id() ?? "";
            //     $audit->role_who_did = Roles::find($role_id)->name ?? "";
            //     $audit->user_type = get_class($getData);
            //     $audit->event = 'listing';
            //     $audit->auditable_type = get_class($getData->getCollection()->first());
            //     $audit->auditable_id = null;
            //     $audit->old_values = null;
            //     $audit->new_values = null;
            //     $audit->url = Request::fullUrl();
            //     $audit->ip_address = Request::ip();
            //     $audit->user_agent = Request::userAgent();
            //     $audit->save();
            // } elseif ($flag == "list by id") {
            //     $audit = new Audit;
            //     $audit->user_id = Auth::id() ?? "";
            //     $audit->role_who_did = Roles::find($role_id)->name ?? "";
            //     $audit->user_type = get_class($getData);
            //     $audit->event = 'listing by id';
            //     $audit->auditable_type = get_class($getData);
            //     $audit->auditable_id = $getData->id;
            //     $audit->old_values = null;
            //     $audit->new_values = null;
            //     $audit->url = Request::fullUrl();
            //     $audit->ip_address = Request::ip();
            //     $audit->user_agent = Request::userAgent();
            //     $audit->save();
            //  }
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'audits',
                'data' => [],
            ];
        }
    }
}
