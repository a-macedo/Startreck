<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use Tests\TestCase;
use Tests\TestHelpers;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class BasicTests extends TestCase
{
    /**
     * Custom Helper Functions
     * 
     * >> email_not_in_user() -> @return true||false 
     * >> random_email() -> @return email
     * 
     */

    // public function email_not_in_use($email)
    // {
    //     return $this->assertDatabaseMissing('users', ['email' => $email]);
    // }

    // public function random_email()
    // {
    //     do
    //     {
    //         $gen_email = 'test_email_' . rand() . '@' . env('APP_DOMAIN', 'local.dev');
    //     }
    //     while (!$this->email_not_in_use($gen_email));

    //     return $gen_email;
    // }

    /**
     * A basic functional test
     * 
     * @return void
     */

    public function test_guest_user_cannot_see_projects_page()
    {
        $response = $this->get('/projects');
        $response->assertStatus(302);
    }
}
//     public function test_guest_user_can_view_login_page()
//     {
//         $response = $this->get('/login');
//         $response->assertSuccessful();
//         $response->assertViewIs('auth.login');
//         echo "\nguest user can view login page";
//     }

//     public function test_authenticated_user_cannot_view_login_page_redirect_to_projects()
//     {
//         $user = factory(User::class)->make();
//         $response = $this->actingAs($user)->get('/login');
//         $response->assertRedirect('/projects');
//         echo "\nauthenticated user cannot view login page and is redirected to projects page";
//     }

//     public function test_user_can_login_with_correct_credentials()
//     {
//         $user = factory(User::class)->create([
//             'password' => bcrypt($password = 'secret-password'),
//         ]);
//         $response = $this->post('/login', [
//             'email' => $user->email,
//             'password' => $password,
//         ]);
//         $response->assertRedirect('/projects');
//         $this->assertAuthenticatedAs($user);
//         echo "\nuser can login with correct credentials";
//     }

//     public function test_user_cannot_login_with_incorrect_password()
//     {
//         $user = factory(User::class)->create([
//             'password' => bcrypt('secret-password'),
//         ]);
        
//         $response = $this->from('/login')->post('/login', [
//             'email' => $user->email,
//             'password' => 'invalid-password',
//         ]);
        
//         $response->assertRedirect('/login');
//         $response->assertSessionHasErrors('email');
//         $this->assertTrue(session()->hasOldInput('email'));
//         $this->assertFalse(session()->hasOldInput('password'));
//         $this->assertGuest();
//         echo "\nuser cannot login with incorrect password";
//     }

//     public function test_user_can_register()
//     {
//         $email = $this->random_email();
//         $user = [
//             'name' => 'Test User',
//             'email' => $email,
//             'password' => 'testuser',
//             'password_confirmation' => 'testuser',
//         ];

//         $response = $this->from('/register')->post('/register', $user);
//         // $response->assertRedirect('/welcome');

//         $this->assertDatabaseHas('users', ['email' => $email]);
//         echo "\n\ncreating new user with email: " . $email;
//         // $this->seePageIs('/welcome')
//         //      ->see('welcome');
//     }

//     public function test_basic_exemple()
//     {
//         $this->assertGuest($guard = null);
//         $response = $this->get('/');
//         $response->assertStatus(302);
//         $response->assertLocation('/projects');
//         // $response->assertSee('Login');
//         echo "\nGuest User >>> Login Page!";
        
//         // else
//         // {
//         //     echo "\nAuthenticated User";
//         //     $try_welcome = $this->get('/welcome');
//         //     $try_welcome->assertStatus(200);
//         //     echo " >>> welcome page!";
//         // }
//     }

// }


// class TestProject extends TestCase
// {
//     /**
//      * Custom Helper Functions
//      * 
//      * >> email_not_in_user() -> @return true||false 
//      * >> random_email() -> @return email
//      * 
//      */

//     // public function email_not_in_use($email)
//     // {
//     //     return $this->assertDatabaseMissing('users', ['email' => $email]);
//     // }

//     // public function random_email()
//     // {
//     //     do
//     //     {
//     //         $gen_email = 'test_email_' . rand() . '@' . env('APP_DOMAIN', 'local.dev');
//     //     }
//     //     while (!$this->email_not_in_use($gen_email));

//     //     return $gen_email;
//     // }

//     /**
//      * A basic functional test
//      * 
//      * @return void
//      */

//     public function test_new_user_can_see_projects_empty_list()
//     {
//         $user = factory(User::class)->make();
//         $response = $this->actingAs($user)->get('/projects');
//         $response->assertSeeTextInOrder(['Projects', 'New Project']);
//         echo "\nnew user can see projects empty list";
//     }

//     public function test_user_can_create_and_view_new_project()
//     {
//         $title = 'project_title_test';
//         $description = 'project_description_test';

//         $user = factory(User::class)->create([
//             'password' => bcrypt($password = 'password'),
//         ]);
//         $response = $this->post('/login', [
//             'email' => $user->email,
//             'password' => $password,
//         ]);
//         $response->assertRedirect('/projects');
//         $this->assertAuthenticatedAs($user);

//         $create_project = $this->get('/projects/create');
//         $create_project->assertSeeText('Create a new Projects');
//         $create_project = $this->post('/projects', [
//             'title' => $title,
//             'dscription' => $description,
//         ]);
//         $create_project->assertRedirect('/projects/create');
//         $create_project->assertSeeTextInOrder(['Projects','0/0']);
//         echo "\nuser can create and view new project";
//     }

//     public function test_user_can_edit_and_view_edited_project()
//     {
//         $this->assertTrue(TRUE);
//     }

//     public function test_user_can_delete_and_cannot_view_deleted_project()
//     {
//         $this->assertTrue(TRUE);
//     }

//     public function test_userB_cannot_see_the_userA_project_using_url()
//     {
//         $this->assertTrue(TRUE);
//     }

// }