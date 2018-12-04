<?php

namespace Tests\Browser;

use App\User;
use App\Project;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class BrowserTest extends DuskTestCase
{
    // use DatabaseTransactions;

    /** @test */
    public function new_user_can_login()
    {
        $user = factory(User::class)->create();
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->screenshot("user_login/login_page")
                    ->press('Login')
                    ->screenshot("user_login/projects_page")
                    ->assertPathIs('/projects')
                    ->assertSee($user->name)
                    ->assertSee('Testing Javascript');
        });
    }

    /** @test */
    public function user_can_create_new_project()
    {
        $user = factory(User::class)->create();
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/projects')
                    ->click('.button')
                    ->assertPathIs('/projects/create')
                    ->assertSee('Create a new Projects')
                    ->type('title', 'My New Project')
                    ->type('description', 'Project description')
                    ->screenshot("create_project/new_projects_page")
                    ->press('Create Project')
                    ->assertPathIs('/projects')
                    ->assertSee('My New Project')
                    ->screenshot("create_project/project_created");
        });
    }

    /** @test */
    public function user_can_edit_project_and_verify_changes()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'title' => 'Test title',
            'owner_id' => $user->id
        ]);
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/projects')
                    ->assertSee('Test title')
                    ->screenshot("edit_project/projects_before")
                    ->click('#app > div > main > ul > li > a')
                    ->click('#app > div > main > div.content > p:nth-child(2) > a:nth-child(1)')
                    ->type('title', 'Test title changed')
                    ->type('description', 'Project new description')
                    ->click('#app > div > main > form:nth-child(2) > div:nth-child(5) > div > button')
                    ->assertPathIs('/projects')
                    ->assertSee('Test title changed')
                    ->screenshot("edit_project/projects_after");
        });
    }

    /** @test */
    public function user_can_delete_project_and_verify_exclusion()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'title' => 'Test title',
            'owner_id' => $user->id
        ]);
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/projects')
                    ->assertSee('Test title')
                    ->screenshot("delete_project/projects_before")
                    ->click('#app > div > main > ul > li > a') //project
                    ->click('#app > div > main > div.content > p:nth-child(2) > a:nth-child(1)') //edit
                    ->click('#app > div > main > form:nth-child(3) > div > div > button') //delete
                    ->assertPathIs('/projects')
                    ->assertDontSee('Test title changed')
                    ->screenshot("delete_project/projects_after");
        });
    }

    /** @test */
    public function user_cannot_see_others_users_projects()
    {
        $userA = factory(User::class)->create();
        $projectA = factory(Project::class)->create([
            'title' => 'prject from user A',
            'owner_id' => $userA->id
        ]);
        $userB = factory(User::class)->create();
        $projectB = factory(Project::class)->create([
            'title' => 'prject from user B',
            'owner_id' => $userB->id
        ]);
        $this->browse(function ($browser) use ($userA, $projectB) {
            $browser->visit('/login')
                    ->type('email', $userA->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/projects')
                    ->assertSee('prject from user A')
                    ->visit('/projects/' . $projectB->id)
                    ->assertTitle('Forbidden')
                    ->screenshot("others_projects/403_page_forbiden");
        });
    }

    /** @test */
    public function user_can_add_tasks_to_existing_project()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'title' => 'Project of 2 Tasks',
            'owner_id' => $user->id
        ]);
        $this->browse(function ($browser) use ($user, $project) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->press('#app > div > main > ul > li > a') //project
                    ->assertPathIs('/projects/' . $project->id)
                    ->type('description', 'task 1')
                    ->press('#app > div > main > form > div.field > div > button') //add task
                    ->type('description', 'task 2')
                    ->press('#app > div > main > form > div.field > div > button') //add task
                    ->assertSee('Project of 2 Tasks')
                    ->screenshot("add_tasks/2_tasks_added")
                    ->assertNotChecked('#app > div > main > div.box > div:nth-child(1) > form > label > input[type="checkbox"]') //checkbox 1
                    ->assertNotChecked('#app > div > main > div.box > div:nth-child(2) > form > label > input[type="checkbox"]') //checkbox 2
                    ->press('#app > div > main > div.box > div:nth-child(2) > form > label > input[type="checkbox"]') //tick checkbox 2
                    ->assertChecked('#app > div > main > div.box > div:nth-child(2) > form > label > input[type="checkbox"]') //checkbox 2
                    ->screenshot("add_tasks/2nd_task_checked");
        });

    }


}
