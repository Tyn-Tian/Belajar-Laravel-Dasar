<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadesTest extends TestCase
{
    public function testConfig()
    {
        $firstName = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        self::assertEquals($firstName, $firstName2);

        var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        $config = $this->app->make('config');
        $firstName = $config->get('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        self::assertEquals($firstName, $firstName2);

        var_dump($config->all());
    }

    public function testConfigMock()
    {
        Config::shouldReceive('get')
            ->with('contoh.author.first')
            ->andReturn('Chris');

        $firstName = Config::get('contoh.author.first');

        self::assertEquals("Chris", $firstName);
    }
}
