<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class apiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetCategories()
    {
        $response = $this->get('/api/categories');     
    
        $response->assertStatus(200)->assertJsonFragment(['id' => 40, 'cate_name' => '陸地']);
    }
    
    public function testGetWords()
    {
        $response = $this->get('/api/words');
    
        $response->assertStatus(200)->assertJsonFragment(['ws_name' => 'カマキリ']);
    }
   
}
