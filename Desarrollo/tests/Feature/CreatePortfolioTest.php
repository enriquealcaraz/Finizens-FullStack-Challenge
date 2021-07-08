<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePortfolioTest extends TestCase
{
    /** @test */
    public function new_valid_portfolio()
    {
        $responsePut = $this->putJson('/portfolio', $this->bodyPut());
        $responsePut->assertStatus(200);
        $responsePut->assertNoContent(200);              
    }
        
    /** @test */
    public function invalid_payload()
    {
        $body = array (
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
                        'id' => 2                        
                    ),
                ),
        );
        
        $responsePut = $this->putJson('/portfolio', $body);
        $responsePut->assertStatus(400);
        $responsePut->assertNoContent(400);      
    }
    
    /** @test */
    public function invalid_method()
    {
        $responsePut = $this->patchJson('/portfolio', $this->bodyPut());
        $responsePut->assertStatus(405);
        $responsePut->assertNoContent(405);      
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
