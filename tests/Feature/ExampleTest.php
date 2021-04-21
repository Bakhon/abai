<?php

namespace Tests\Feature;

use Carbon\Carbon;
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
        Carbon::parse(now());

        $arr = ['test'=>'kiki'];

        foreach ($arr as $key => $val){
            dd($key, $val);
        }

        dd(now()->setTime(0, 0, 0)->toDateTimeLocalString());

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
