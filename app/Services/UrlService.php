<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class UrlService
{

    public function deleteOldUrls(?int $days = 30)
    {
        if (empty($days)) {
            $days = 30;
        }

        DB::table('urls')
            ->whereRaw('DATEDIFF(updated_at, created_at) >= ?', [$days])
            ->delete();
    }

}
