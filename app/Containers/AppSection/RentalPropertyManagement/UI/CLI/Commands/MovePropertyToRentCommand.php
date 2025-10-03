<?php

namespace App\Containers\AppSection\RentalPropertyManagement\UI\CLI\Commands;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\AppSection\Notifications\Models\Notifications;
use App\Containers\AppSection\Propertymaster\Models\PropertymasterDetails;
use App\Containers\AppSection\RentalPropertyManagement\Models\RentalPropertyManagement;
use App\Containers\AppSection\TaskManagement\Models\TaskManagement;
use App\Containers\AppSection\TaskManagement\Models\TaskManagementCustomNotification;
use App\Containers\AppSection\TaskManagement\Tasks\SendTaskManagementRemainderMailTask;
use App\Ship\Parents\Absoluteweb\AbsolutewebRepository;
use App\Ship\Parents\Commands\ConsoleCommand;
use App\Ship\Transporters\DataTransporter;
use Log;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use GuzzleHttp\Client;

/**
 * Class CreateAdminCommand
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class MovePropertyToRentCommand extends ConsoleCommand
{

    protected $signature = 'apiato:MovePropertyToRent';

    protected $description = 'Move Property To Rent';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Move Property To Rent Cron ...Start");
        Log::info("Move Property To Rent Cron date" . date('Y-m-d'));
        $currentDate = date('Y-m-d');
        $getRentalData = RentalPropertyManagement::whereDate('lease_end_date', '<=', $currentDate)->where('lease_status', 1)->get();

        if (!empty($getRentalData) && count($getRentalData) >= 1) {
            for ($i = 0; $i < count($getRentalData); $i++) {
                $getUnitData = PropertymasterDetails::where('id', $getRentalData[$i]->pro_property_master_details_id)->update(['property_status' => 1]);
                $updateRentalStatus = RentalPropertyManagement::where('id', $getRentalData[$i]->id)->update(['lease_status' => 0]);
            }
        }

        Log::info("Move Property To Rent Cron ...Finish");
    }
}
