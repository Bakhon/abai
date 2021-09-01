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
        $data = [];

        $data['test'] +=1;

        dd($data);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
