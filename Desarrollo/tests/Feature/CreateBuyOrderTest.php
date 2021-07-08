<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBuyOrderTest extends TestCase
{
    /** @test */
    public function buy_more_shares_on_allocation()
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
    }
    
    /** @test */
    public function buy_a_new_allocation()
    {
        $responsePut = $this->putJson('/portfolio', $this->bodyPut());
        $responsePut->assertStatus(200);
        $responsePut->assertNoContent(200);
        
        $bodyPost = array (
            'id' => 1,
            'portfolio' => 1,
            'allocation' => 3,
            'shares' => 2
        );
        
        $responsePost = $this->postJson('/buy', $bodyPost);
        $responsePost->assertStatus(404);
        $responsePost->assertNoContent(404);        
    }
    
    /** @test */
    public function buy_unknown_portfolio()
    {
        $bodyPost = array (
            'id' => 1,
            'portfolio' => 101,
            'allocation' => 3,
            'shares' => 2
        );
        
        $responsePost = $this->postJson('/buy', $bodyPost);
        $responsePost->assertStatus(404);
        $responsePost->assertNoContent(404);    
    }
    
    /** @test */
    public function invalid_method()
    {
        $responsePost = $this->putJson('/buy');
        $responsePost->assertStatus(405);
        $responsePost->assertNoContent(405);   
    }
    
    /** @test */
    public function buy_invalid_payload()
    {
        $bodyPost = array (
            'id' => 1           
        );
        
        $responsePost = $this->postJson('/buy', $bodyPost);
        $responsePost->assertStatus(400);
        $responsePost->assertNoContent(400); 
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
