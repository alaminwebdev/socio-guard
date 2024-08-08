<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Model\Selpzone;
class SelpzoneTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $zone = factory(Selpzone::class,100)->make();
        $this->assertTrue(count($zone)==100,"Failed to create selpzone");
        
    }
}
