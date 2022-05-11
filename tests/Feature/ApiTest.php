<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{

    /**
     * Test for zip-codes:start command
     *
     * @return void
     */
    public function test_apopulate_database()
    {
        $this->artisan('zip-codes:start')->assertSuccessful();
    }


    /**
     * Test for API
     *
     * @return void
     */
    public function test_api()
    {
        $zip_code = rand(1000, 99998);
        $response = $this->get("/api/zip-codes/{$zip_code}");

        $response->assertStatus(200);
    }
}
