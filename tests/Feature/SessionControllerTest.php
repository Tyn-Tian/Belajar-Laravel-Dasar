<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSessionHas('User-Id', 'Christian')
            ->assertSessionHas('Is-Member', 'true');
    }

    public function testGetSession()
    {
        $this->withSession([
            "User-Id" => "Christian",
            "Is-Member" => "true"
        ])->get('/session/get')
            ->assertSeeText("User Id : Christian, Is Member : true");
    }

    public function testGetSessionFailed()
    {
        $this->withSession([])
            ->get('/session/get')
            ->assertSeeText("User Id : guest, Is Member : false");
    }
}
