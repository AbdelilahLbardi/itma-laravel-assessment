<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldUrls;
use Illuminate\Console\Command;

class RemoveOldUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urls:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'deletes links that were not visited for the past X days (30 by default)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DeleteOldUrls::dispatch();

        return Command::SUCCESS;
    }
}
