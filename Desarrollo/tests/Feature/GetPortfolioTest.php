<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetPorfolioTest extends TestCase
{
    /** @test */
    public function get_a_valid_portfolio()
    {
        $responsePut = $this->putJson('/portfolio', $this->bodyPut());
        $responsePut->assertStatus(200);
        $responsePut->assertNoContent(200);
        
        $responsePost = $this->get('/portfolio/1');
        $responsePost->assertStatus(200);
        $responsePost->assertJson($this->bodyPut());        
    }
    
    /** @test */
    public function invalid_method()
    {
        $responsePost = $this->patchJson('/portfolio/1');
        $responsePost->assertStatus(405);
        $responsePost->assertNoContent(405);   
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
