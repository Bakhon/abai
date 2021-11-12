<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        dd(max(0, null + 2, 1));

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
