<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/api/v1/project-assign-users/PRODUCT_OWNER',[
            "project_id"=>"1f6f7a91-0eea-481d-8471-362fb15f16db",
            "user_ids"=>["7234d21c-aa56-40b0-a878-aebfc4e3e4a9","d43b91fd-a269-44ff-a5d2-2049912747b1"]
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message'
            ]);
    }
}
