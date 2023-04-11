<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeTaskStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->put('/api/v1/task-status-change/51138701-98d1-4215-9034-0d974fbc2f20/TEAM_MEMBER',
                        [
                        "title"=>"title of task",
                        "description"=>"desc",
                        "status"=>"READY_FOR_TEST",
                        "team_member_id"=>"7234d21c-aa56-40b0-a878-aebfc4e3e4a9"
                        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data'=>[
                "id",
                "title",
                "description",
                "status",
                "project_id",
                "user_id",
                "created_at",
                "updated_at"
            ]
            ]);
    }
}
