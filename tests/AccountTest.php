<?php

use Laracasts\TestDummy\Factory;

class AccountTest extends IntegrationTestCase
{
    public function test_it_deletes_the_user_account()
    {
        $user = Factory::create('user');
        $this->actingAs($user)
             ->visit('account/delete')
             ->press('Yes')
             ->seePageIs('/')
             ->see('Successfully deleted account.');

        $this->dontSeeInDatabase('users', [
            'email' => $user->email,
        ]);
    }

    public function test_it_deletes_users_associated_entities()
    {
        $user = Factory::create('user');

        $talk = Factory::build('talk');
        $user->talks()->save($talk);
        $talkRevision = Factory::build('talkRevision');
        $talk->revisions()->save($talkRevision);

        $this->actingAs($user)
             ->visit('account/delete')
             ->press('Yes')
             ->seePageIs('/')
             ->see('Successfully deleted account.');

        $this->dontSeeInDatabase('users', [
            'email' => $user->email,
        ]);

        $this->dontSeeInDatabase('talks', [
            'id' => $talk->id,
        ]);


        // bio
    }
}
