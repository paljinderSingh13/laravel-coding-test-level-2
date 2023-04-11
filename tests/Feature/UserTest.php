<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/api/v1/users/ADMIN',[
            "name"=>"TM 02",
            "username"=> "TM02",
            "email"=> "tm02@gmail.com",
            "password"=>"123456",
            "role"=>"TEAM_MEMBER"
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'user' => [
                "name",
                "username",
                "email",
                "role",
                "id" ,
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
