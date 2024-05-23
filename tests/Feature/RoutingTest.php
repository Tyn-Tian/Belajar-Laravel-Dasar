<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testBasicRouting()
    {
        $this->get('/tyn')
            ->assertStatus(200)
            ->assertSeeText("Hello Christian");
    }

    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/tyn');
    }

    public function testFallback()
    {
        $this->get('/404')
            ->assertSeeText('404');
    }
}
