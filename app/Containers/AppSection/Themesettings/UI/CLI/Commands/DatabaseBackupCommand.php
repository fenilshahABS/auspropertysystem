<?php

namespace App\Containers\AppSection\Themesettings\UI\CLI\Commands;


use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Commands\ConsoleCommand;
use Symfony\Component\Process\Process;
use Log;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class CreateAdminCommand
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class DatabaseBackupCommand extends ConsoleCommand
{

    protected $signature = 'apiato:DatabaseBackup';

    protected $description = 'Database Backup';

    protected $process;

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
        Log::info("Database Backup Cron ...Start");
        Log::info("Database Backup Cron date" . date('Y-m-d'));

        $date = date('Y-m-d');


        Log::info("Database Backup Cron...Finish");
    }
}
