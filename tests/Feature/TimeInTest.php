<?php

namespace Tests\Feature;

use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TimeInTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $auth_user;


    public function setUp(): void
    {
        parent::setUp();
        $this->auth_user = $this->createUser();
    }

    public function test_time_in()
    {
        $response = $this->actingAs($this->auth_user)
            ->json(Request::METHOD_POST, route('timein'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
