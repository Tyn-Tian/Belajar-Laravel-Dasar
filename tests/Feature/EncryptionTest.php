<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $encrypy = Crypt::encrypt("Christian");
        $decrypt = Crypt::decrypt($encrypy);

        self::assertEquals("Christian", $decrypt);
    }
}
