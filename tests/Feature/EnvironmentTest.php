<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    public function testGetEnv()
    {
        // file .env: BELAJAR="Laravel Dasar"
        $belajar = env('BELAJAR');

        self::assertEquals('Laravel Dasar', $belajar);
    }

    public function testDefaultEnv()
    {
        $author = Env::get('AUTHOR', 'Tyn');

        self::assertEquals('Tyn', $author);
    }
}
