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

    public function testRouteParameter()
    {
        $this->get('/products/1')
            ->assertSeeText("Product 1");

        $this->get('/products/2')
            ->assertSeeText("Product 2");

        $this->get('/products/1/items/XXX')
            ->assertSeeText("Product 1, Item XXX");

        $this->get('/products/2/items/YYY')
            ->assertSeeText("Product 2, Item YYY");
    }

    public function testRouteParameterRegex()
    {
        $this->get('/categories/100')
            ->assertSeeText("Category 100");

        $this->get('/categories/notfound')
            ->assertSeeText("404");
    }

    public function testRouteParameterOptional()
    {
        $this->get('/users/tian')
            ->assertSeeText('User tian');

        $this->get('/users/')
            ->assertSeeText('User 404');
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText("Conflict budi");

        $this->get('/conflict/tyn')
            ->assertSeeText("Conflict Christian");
    }

    public function testnameRoute()
    {
        $this->get('/produk/12345')
            ->assertSeeText('Link : http://localhost/products/12345');

        $this->get('/produk-redirect/12345')
            ->assertRedirect('/products/12345');
    }

    public function testController()
    {
        $this->get('/controller/hello/tian')
            ->assertSeeText("Hallo tian");
    }

    public function testRequest()
    {
        $this->get('/controller/hello/request', [
            'Accept' => 'plain/text'
        ])->assertSeeText('controller/hello/request')
            ->assertSeeText('http://localhost/controller/hello/request')
            ->assertSeeText('GET')
            ->assertSeeText('plain/text');
    }
}
