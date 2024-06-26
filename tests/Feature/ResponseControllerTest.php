<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSeeText("Hello Response");
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText("Chris")->assertSeeText("Tian")
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Christian')
            ->assertHeader('App', 'Belajar Laravel Dasar');
    }

    public function testView()
    {
        $this->get('/response/type/view')
            ->assertSeeText("Hello Christian");
    }

    public function testJson()
    {
        $this->get('/response/type/json')
            ->assertJson(['firstName' => "Chris", 'lastName' => "Tian"]);
    }

    public function testFile()
    {
        $this->get('/response/type/file')
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testDownload()
    {
        $this->get('/response/type/download')
            ->assertDownload('Christian.png');
    }
}