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
class UrlCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Auth::login($this->user);
    }

    public function test_create_destination()
    {
        $this->createUrl($this->validData());

        self::assertDatabaseHas(Url::class, $this->validData([
            'user_id' => $this->user->id
        ]));
    }

    /**
     * @dataProvider destinationsProvider
     */
    public function test_create_destination_input($input, $errorMessage)
    {
        $this->createUrl(['destination' => $input])
            ->assertJsonValidationErrors([
                'destination' => [
                    $errorMessage
                ]
            ]);
    }

    public function test_cannot_create_destination_that_targets_our_base()
    {
        $this->createUrl(['destination' => config('app.url')])
            ->assertJsonValidationErrors([
                'destination' => [
                    'You cannot use our URL as destination.'
                ]
            ]);
    }

    public function test_user_cannot_create_two_shortened_links_for_the_same_direction()
    {
        Url::factory()->create([
            'user_id' => $this->user->id,
            'destination' => $destination = 'https://test-link.com/url?query=test'
        ]);

        self::assertDatabaseCount(Url::class, 1);
        self::assertDatabaseHas(Url::class, [
            'user_id' => $this->user->id,
            'destination' => $destination
        ]);

        $this->createUrl(['destination' => $destination]);

        self::assertDatabaseCount(Url::class, 1);
        self::assertDatabaseHas(Url::class, [
            'user_id' => $this->user->id,
            'destination' => $destination
        ]);
    }

    private function validData($data = []): array
    {
        return array_merge([
            'destination' => 'https://google.com'
        ], $data);
    }

    private function createUrl($data = []): TestResponse
    {
        return $this->postJson(route('urls.store'), $data);
    }

    public function destinationsProvider(): array
    {
        return [
            ['hello', 'The destination must be a valid URL.'],
            ['http: /', 'The destination must be a valid URL.'],
            ['https:://google.', 'The destination must be a valid URL.']
        ];
    }
}
