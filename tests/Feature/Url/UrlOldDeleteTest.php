<?php

namespace Tests\Feature\Url;

use App\Models\Url;
use App\Models\User;
use App\Services\UrlService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @group url
 */
class UrlOldDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected UrlService $urlService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->urlService = resolve(UrlService::class);

        Carbon::setTestNow('2022-01-01');
    }

    public function test_visited_url_withing_30_days_are_not_deleted()
    {
        $url = Url::factory()->create();

        $this->get($url->slug);

        $this->urlService->deleteOldUrls();

        self::assertDatabaseHas(Url::class, [
            'id' => $url->id
        ]);
    }



    public function test_unvisited_url_withing_30_days_are_deleted()
    {
        $url = Url::factory()->create();
        Url::factory()->count(5)->create();

        Carbon::setTestNow(
            Carbon::createFromDate(2022, 01, 01)->addDays(30)->format('Y-m-d')
        );

        $this->get($url->slug);

        $this->urlService->deleteOldUrls();

        self::assertDatabaseHas(Url::class, [
            'id' => $url->id,
            'slug' => $url->slug
        ]);

        self::assertDatabaseCount(Url::class, 1);
    }

}
