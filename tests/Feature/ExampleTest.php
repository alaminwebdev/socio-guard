<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user=factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get('view_incident');
        $response->assertViewHas('incidents');
        $response->assertViewIs('backend.admin.incident.incident-list');
        //$response->assertStatus(200);
    }
}
