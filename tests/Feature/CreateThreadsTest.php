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


   // function test_guest_can_not_create_threads()
   // {
   //     $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
 //
  //      $thread = make('App\Thread');

  //      $this->post('/threads', $thread->toArray());
  //  }


    function test_guest_can_not_create_threads()
    {
        $this->get('/threads/create')->assertRedirect('/login');

        $this->post('/threads')->assertRedirect('login');
    }

    function test_a_logged_in_user_can_create_new_threads()
    {
        $this->withoutExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $response = $this->post('/threads', $thread->toArray());
        dd($response->headers->get('Location'));
    }

    function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
    function test_a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 777])
            ->assertSessionHasErrors('channel_id');
    }
    function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App/User', $this->thread->creator);
    }
    function test_a_thread_has_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals(
                  "/threads/'{$this->channel->slug}/{$this->id}", $thread->path());

    }
    function test_a_thread_can_be_deleted()
    {
        $this->withoutExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id', $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        'subject_id' => $thread->id,
        'subject_type' => get_class($thread)
    }
    public function test_unauthorized_users_can_not_delete_threads()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertRedirect('/login');
        $this->delete($thread->path())->assertStatus(403);
    }
}

