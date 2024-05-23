<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText("Hello Christian");

        $this->get('/hello-again')
            ->assertSeeText("Hello Christian");
    }

    public function testViewNested()
    {
        $this->get('/hello-world')
            ->assertSeeText("World Christian");
    }

    public function testViewWithoutRouting() 
    {
        $this->view('hello', ['name' => 'Christian'])
            ->assertSeeText("Hello Christian");
    }
}
