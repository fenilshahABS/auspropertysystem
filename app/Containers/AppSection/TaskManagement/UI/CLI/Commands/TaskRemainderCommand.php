<?php

namespace App\Containers\AppSection\TaskManagement\UI\CLI\Commands;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\AppSection\Notifications\Models\Notifications;
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
class TaskRemainderCommand extends ConsoleCommand
{

    protected $signature = 'apiato:TaskRemainder';

    protected $description = 'Task Remainder';

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
        Log::info("Task Remainder Cron ...Start");
        Log::info("Task Remainder Cron date" . date('Y-m-d'));
        $currentDate = date('Y-m-d');
        $getTasks = TaskManagement::whereDate('task_datetime', $currentDate)->where('status', 0)->get();

        if (!empty($getTasks) && count($getTasks) >= 1) {
            for ($i = 0; $i < count($getTasks); $i++) {
                $taskDateTime = strtotime($getTasks[$i]->task_datetime);
                $currentDateTime = time();
                $check_custom_notifications = TaskManagementCustomNotification::where('task_management_id', $getTasks[$i]->id)->first();
                if (empty($check_custom_notifications)) {
                    if ($currentDateTime >= ($taskDateTime - 30 * 60) && $currentDateTime < $taskDateTime) {
                        $getData = [
                            "user_id" => $getTasks[$i]->user_id,
                            "task_name" => $getTasks[$i]->task_name,
                            "custom_email" => $getTasks[$i]->custom_email,
                            "task_datetime" => $getTasks[$i]->task_datetime,
                        ];

                        $sendPaymentRemainder = AbsolutewebRepository::sendTaskRemainderNotification($getData);
                    }
                } else {
                    $getData = [
                        "user_id" => $getTasks[$i]->user_id,
                        "task_name" => $getTasks[$i]->task_name,
                        "custom_email" => $getTasks[$i]->custom_email,
                        "task_datetime" => $check_custom_notifications->task_datetime,
                    ];
                    $sendPaymentRemainder = AbsolutewebRepository::sendTaskRemainderNotification($getData);
                }
            }
        }

        Log::info("Task Remainder Cron...Finish");
    }
}
