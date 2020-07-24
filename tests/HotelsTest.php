<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class HotelsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetHotels()
    {
        $this->call('POST', '/getHotels', 
        [
            'from_date' => '2020-7-03',
            'to_date' => '2020-7-23',
            'city' => 'AUH', 
            'adults_number' => 3
        ])-> assertStatus(200);
       // $this->assertEquals(200, $response->status());
        //$response->assertStatus(200);
    }
}
