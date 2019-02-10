<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    public function test_dashboard_loads()
    {
        $this->actingAs($this->user)->get('/')
            ->assertOk();
    } // end test_dashboard_loads
} // end DashboardControllerTest
