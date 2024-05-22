<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        $foo = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertEquals("Foo", $foo->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo, $foo2);
    }

    public function testBind()
    {
        $this->app->bind(Person::class, function ($app) {
            return new Person("Chris", "Tian");
        });

        $person = $this->app->make(Person::class); // closure() // new Person("Chris", "Tian")
        $person2 = $this->app->make(Person::class); // closure() // new Person("Chris", "Tian")

        self::assertEquals("Chris", $person->firstName); 
        self::assertEquals("Chris", $person2->firstName); 
        self::assertNotSame($person, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app) {
            return new Person("Chris", "Tian");
        });

        $person = $this->app->make(Person::class); // new Person("Chris", "Tian") if not existing
        $person2 = $this->app->make(Person::class); // return existing

        self::assertEquals("Chris", $person->firstName); 
        self::assertEquals("Chris", $person2->firstName); 
        self::assertSame($person, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Chris", "Tian");
        $this->app->instance(Person::class, $person);

        $person = $this->app->make(Person::class); // $person
        $person2 = $this->app->make(Person::class); // $person

        self::assertEquals("Chris", $person->firstName); 
        self::assertEquals("Chris", $person2->firstName); 
        self::assertSame($person, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        self::assertSame($foo, $bar->foo);
    }

    public function testDependencyInjectionInClosure()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });

        $bar = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);
        self::assertSame($bar, $bar2);
    }

    public function testHelloService()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        // $this->app->singleton(HelloService::class, function ($app) {
        //     return new HelloServiceIndonesia(); // jika ada parameter
        // });

        $helloService = $this->app->make(HelloService::class);
        self::assertEquals("Hallo Tian", $helloService->hello("Tian"));
    }
}
