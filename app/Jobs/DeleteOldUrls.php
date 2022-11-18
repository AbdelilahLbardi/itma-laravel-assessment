<?php

namespace App\Jobs;

use App\Services\UrlService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteOldUrls implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?int $days;

    public function __construct(?int $days = 30)
    {
        $this->days = $days;
    }

    public function handle(UrlService $urlService)
    {
        $urlService->deleteOldUrls($this->days);
    }
}
