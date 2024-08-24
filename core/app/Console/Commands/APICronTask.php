<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\ManageApiController;

class APICronTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoke API fetching action';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apiController = app(ManageApiController::class);
        $result = $apiController->apiCronJob();

        if(!$result){
            $this->error('API Cron Job failed');
        }

        $this->info($result);
        $this->info("API Cron Job Successful");
    }
}
