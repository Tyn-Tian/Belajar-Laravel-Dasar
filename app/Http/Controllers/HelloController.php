<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\HelloService;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function __construct(
        private HelloService $helloService
    ) {
    }

    public function hello($name) 
    {
        return $this->helloService->hello($name);
    }
}
