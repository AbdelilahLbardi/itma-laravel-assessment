<?php

namespace Tests\Feature\Url;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @group url
 */
class ApiUrlCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_destination()
    {
        $this->createUrl($this->validData())
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @dataProvider destinationsProvider
     */
    public function test_create_destination_input($input, $errorMessage)
    {
        $this->createUrl(['destination' => $input])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'destination' => [
                    $errorMessage
                ]
            ]);
    }

    public function test_cannot_create_destination_that_targets_our_base()
    {
        $this->createUrl(['destination' => config('app.url')])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'destination' => [
                    'You cannot use our URL as destination.'
                ]
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
        return $this->postJson(route(RouteServiceProvider::CURRENT_API_VERSION . '.urls.store'), $data);
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
