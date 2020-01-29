<?php

namespace Tests\Feature;
 
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
 
   public function test_unauthenticated_users_can_not_add_replies()
    {
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/1/replies', []);
    }
 
    public function test_an_authenticated_user_can_participate_in_forum_threads()
   {
       $this->be($user = factory('App\User')->create());
 
       $thread = factory('App\Thread')->create();
 
       $reply = factory('App\Reply')->make();

       $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
 
       $this->get($thread->path())->assertSee($reply->body);
    }
}
