<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompleteAnActiveOrderTest extends TestCase
{
    /** @test */
    public function complete_a_buy_order()
    {
        $responsePut = $this->putJson('/portfolio', $this->bodyPut());
        $responsePut->assertStatus(200);
        $responsePut->assertNoContent(200);
        
        $bodyPost = array (
            'id' => 1,
            'portfolio' => 1,
            'allocation' => 1,
            'shares' => 3
        );
        
        $responsePost = $this->postJson('/buy', $bodyPost);
        $responsePost->assertStatus(200);
        $responsePost->assertNoContent(200);
        
        $bodyComplete = array('id' => 1);
        
        $responseComplete = $this->postJson('/complete', $bodyComplete);
        $responseComplete->assertStatus(200);
        $responseComplete->assertNoContent(200);
    }
    
    /** @test */
    public function  a_unknown_order()
    {
        $bodyComplete = array('id' => 401);
        
        $responseComplete = $this->postJson('/complete', $bodyComplete);
        $responseComplete->assertStatus(404);
        $responseComplete->assertNoContent(404);
    }
    
    /** @test */
    public function invalid_method()
    {
        $responsePost = $this->putJson('/complete');
        $responsePost->assertStatus(405);
        $responsePost->assertNoContent(405);    
    }
    
    
    public function buy_invalid_payload()
    {
        $payload = '{
            "id": 1,
        }';
        
        $bodyComplete = (!empty(json_decode($payload, true)) ? $bodyComplete : array()); 
               
        $responseComplete = $this->postJson('/complete', $bodyComplete);
        $responseComplete->assertStatus(400);
        $responseComplete->assertNoContent(400);
    }
    
    private function bodyPut()
    {
        return array (
            'id' => 1,
            'allocations' => 
                array (
                    0 => 
                    array (
                        'id' => 1,
                        'shares' => 3,
                    ),
                    1 => 
                    array (
                        'id' => 2,
                        'shares' => 4,
                    ),
                ),
        );
    }   
}
