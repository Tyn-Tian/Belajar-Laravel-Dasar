<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=tian')
            ->assertSeeText('Hello tian');

        $this->post('/input/hello', [
            'name' => 'Tian'
        ])->assertSeeText('Hello Tian');
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "Chris",
                "last" => "Tian"
            ]
        ])->assertSeeText("Hello Chris");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            "name" => [
                "first" => "Chris",
                "last" => "Tian"
            ]
        ])->assertSeeText("name")->assertSeeText("first")
            ->assertSeeText("last")->assertSeeText("Chris")
            ->assertSeeText("Tian");
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Apple Mac Book Pro",
                    "price" => 30000000
                ],
                [
                    "name" => "Samsung Galaxy S10",
                    "price" => 15000000
                ]
            ],
        ])->assertSeeText("Apple Mac Book Pro")
            ->assertSeeText("Samsung Galaxy S10");
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            "name" => "Budi",
            "married" => "true",
            "birth_date" => "1990-10-10"
        ])->assertSeeText("Budi")->assertSeeText("true")->assertSeeText("1990-10-10");
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "Chris",
                "middle" => "tyn",
                "last" => "Tian"
            ]
        ])->assertSeeText("Chris")->assertSeeText("Tian")
            ->assertDontSeeText("tyn");
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            "username" => "Christian",
            "admin" => "true",
            "password" => "rahasia"
        ])->assertSeeText("Christian")->assertSeeText("rahasia")
            ->assertDontSeeText("admin");
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            "username" => "Christian",
            "admin" => "true",
            "password" => "rahasia"
        ])->assertSeeText("Christian")->assertSeeText("rahasia")
            ->assertSeeText("admin")->assertSeeText("false");
    }
}
