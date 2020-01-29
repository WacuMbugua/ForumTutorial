<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**@test */

    
    function test_guest_can_not_create_threads()
    {
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
 
        $thread = make('App\Thread');
 
        $this->post('/threads', $thread->toArray());
    }


    function test_guest_can_not_see_thread_create_form()
    {
        $this->withExceptionHandling()->get('/threads/create')->assertRedirect('/login');
    }
 

    function test_a_logged_in_user_can_create_new_threads()
    {
        // A signed in user
      
        $this->signIn();
 
        // When visiting to create a new thread
        $thread = make('App\Thread');
 
        // Submit the thread
        $this->post('/threads', $thread->toArray());
 
        // Visit the thread page
        $this->get($thread->path())
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }
}
