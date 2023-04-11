<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/api/v1/project/PRODUCT_OWNER',[
            "name"=>"Project e"
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'Project' => [
                "name",
                "id" ,
                'created_at',
                'updated_at',
            ]
        ]);

    }


}
