<?php

namespace Tests\Unit\Http\Middleware;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Middleware\AccessEnabled;

class AccessEnabledTest extends TestCase
{
    private $middleware;
    private $next;

    public function setUp()
    {
        parent::setUp();

        $this->middleware = new AccessEnabled();
        $this->next = function ($request) {
            return $request;
        };
    }

    public function test_permits_authorized_users()
    {
        $user = factory(\App\Models\User::class)->create();

        $response = $this->middleware->handle($this->mockRequest($user), $this->next);
        $this->assertInstanceOf(Request::class, $response);
    }

    public function test_blocks_unauthorized_users()
    {
        $user = factory(\App\Models\User::class)->create(['app_access_enabled' => false]);

        $response = $this->middleware->handle($this->mockRequest($user), $this->next);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    private function mockRequest($user)
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())->method('user')->willReturn($user);

        return $request;
    }
}
