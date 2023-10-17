<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
