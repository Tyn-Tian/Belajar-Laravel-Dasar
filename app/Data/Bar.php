<?php

namespace App\Data;

class Bar
{
    public function __construct(
        private Foo $foo
    ) {
    }

    public function bar(): string
    {
        return $this->foo->foo() . " and Bar";
    }
}
