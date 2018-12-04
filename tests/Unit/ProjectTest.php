<?php

namespace Tests\Unit;

use App\User;
use App\Project;
use Tests\TestCase;
use Tests\TestHelpers;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class TestProject extends TestCase
{

    use DatabaseTransactions;
    // data will NOT be percisted in database!

    // protected function create_user()
    // {
    //     return factory(User::class)->create();
    // }

    /**
     * A basic functional test
     * 
     * @return void
     */

    /** @test */ 
    public function new_user_can_see_only_projects_empty_list()
    {
        $user = factory(User::class)->create();
        $projects = $user->projects()->get();

        $this->assertCount(0, $projects);
        $response = $this->actingAs($user)->get('/projects');
        $response->assertSeeTextInOrder(['Projects', 'New Project']);
    }

    /** @test */
    public function user_can_create_and_view_projects()
    {
        $user = factory(User::class)->create();
        $created_projects = factory(Project::class, 4)->create(['owner_id' => $user->id]);

        $projects = $user->projects()->get();
        $this->assertEquals($projects->first()->id, $created_projects->first()->id);
        $this->assertCount(4, $projects);
    }

    /** @test */
    public function user_can_edit_and_view_edited_project()
    {
        $user = factory(User::class)->create(); 
        $project = factory(Project::class)->create([
            'owner_id' => $user->id,
            'title' => 'title',
            'description' => 'description',
        ]);

        $response =  $this->actingAs($user)
                          ->call('PATCH', '/projects/'.$project->id, 
                                ['title' => 'new title', 'description' => 'new description'],
                                [/* cookies */],[/* files */],[/* token */]);

        $projects = $user->projects()->get();

        $this->assertEquals(302, $response->status());
        $this->assertCount(1, $projects);
        $this->assertEquals($projects->first()->title, 'new title');
    }

    /** @test */
    public function user_can_delete_and_cannot_view_deleted_project()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create(['owner_id' => $user->id]);

        $response =  $this->actingAs($user)
                          ->call('DELETE', '/projects/'.$project->id, 
                                [/* arguments */],[/* cookies */],[/* files */],[/* token */]);

        $projects = $user->projects()->get();

        $this->assertEquals(302, $response->status());
        $this->assertCount(0, $projects);

        $response = $this->actingAs($user)->get('/projects');
        $response->assertSeeTextInOrder(['Projects', 'New Project']);
    }

    /** @test */
    public function userB_cannot_see_the_userA_project()
    {
        $userA = factory(User::class)->create(); 
        $userB = factory(User::class)->create(); 

        $projectA = factory(Project::class)->create(['owner_id' => $userA->id]);
        $projectB = factory(Project::class)->create(['owner_id' => $userB->id]);

        $response =  $this->actingAs($userB)
                          ->call('GET', '/projects/'.$projectA->id, 
                                [/* arguments */],[/* cookies */],[/* files */],[/* token */]);

        $this->assertEquals(403, $response->status()); //Forbiden   
    }

}
