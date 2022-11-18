<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldUrls;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveOldUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urls:clear {days=30}';

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
        DeleteOldUrls::dispatch($this->argument('days'));

        return Command::SUCCESS;
    }
}
