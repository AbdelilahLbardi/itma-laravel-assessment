<?php

namespace Tests\Feature\Url;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @group url
 */
class UrlVisitTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    private Url $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->url = Url::factory()->create([
            'user_id' => $this->user->id
        ]);

        Auth::login($this->user);
    }

    public function test_visit_url()
    {
        $this->get($this->url->slug)->assertRedirect($this->url->destination);
    }

    public function test_visiting_url_increments_views()
    {
        self::assertEquals(0, $this->url->views);

        $this->get($this->url->slug)->assertRedirect($this->url->destination);
        self::assertEquals(1, $this->url->fresh()->views);

        $this->get($this->url->slug)->assertRedirect($this->url->destination);
        self::assertEquals(2, $this->url->fresh()->views);
    }


    public function test_visiting_url_from_internal_team_is_not_incrementing_views()
    {
        self::assertEquals(0, $this->url->views);

        $this->get($this->url->slug)->assertRedirect($this->url->destination);
        self::assertEquals(1, $this->url->fresh()->views);

        $this->get($this->url->slug . '?type=internal')->assertRedirect($this->url->destination);
        self::assertEquals(1, $this->url->fresh()->views);
    }

}
