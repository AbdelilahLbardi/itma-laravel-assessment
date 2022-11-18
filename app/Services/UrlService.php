<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class UrlService
{

    public function deleteOldUrls()
    {
        DB::transaction(function () {
            DB::table('urls')
                ->whereRaw("DATEDIFF(?, updated_at) >= ?", [now()->format('Y-m-d'), config('services.url_deletion.expiry_days')])
                ->delete();
        });
    }

}
