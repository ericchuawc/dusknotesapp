<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\NotesPage;
use Tests\Browser\Pages\SignUpPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test A user should see no notes when starting their account
     * 
     * @return void
     */
    public function a_user_should_see_no_notes_when_starting_their_account()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new SignUpPage)
            ->signUp('Tabby Garett', 'tabby@codecourse.com', 'password', 'password')
            ->visit('/home')
            ->assertSee('No notes yet')
            ->assertSee('Untitled')
            ->assertValue('@title', '')
            ->assertValue('@body', '');
        });
    }

    /**
     * @test A user can save a new note
     * 
     * @return void
     */
    public function a_user_can_save_a_new_note()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new NotesPage)
                ->typeNote('One', 'Some body')
                ->saveNote()
                ->pause(500)
                ->assertSeeIn('.alert', 'Your new note has been saved.')
                ->assertSeeIn('.notes', 'One')
                ->assertInputValue('@title', 'One')
                ->assertInputValue('@body', 'Some body');
        });
    }

    /**
     * @test A user can see the word count of their note
     * 
     * @return void
     */
    public function a_user_can_see_the_word_count_of_their_note()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new NotesPage)
                ->typeNote('One', 'There are five words here')
                ->assertSee('Word count: 5');
        });
    }

    /** 
     * @test A user can start a fresh note
     * 
     * @return void
     */
    public function a_user_can_start_a_fresh_note()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new NotesPage)
                ->typeNote('One', 'First note')
                ->saveNote()
                ->pause(500)
                ->clickLink('Create new note')
                ->pause(500)
                ->assertSeeIn('.alert', 'A fresh note has been created.')
                ->assertInputValue('@title', '')
                ->assertInputValue('@body', '');
        });
    }

    /**
     * @test A user's current note is saved when starting a new note
     * 
     * @return void
     */
    public function a_users_current_note_is_saved_when_starting_a_new_note()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new NotesPage)
                ->typeNote('One', 'First note')
                ->saveNote()
                ->pause(500)
                ->type('@title', 'One updated')
                ->type('@body', 'First note updated')
                ->clickLink('Create new note')
                ->pause(500)
                ->assertSeeIn('.notes', 'One updated')
                ->clickLink('One updated')
                ->pause(500)
                ->assertInputValue('@title', 'One updated')
                ->assertInputValue('@body', 'First note updated');
        });
    }

    /**
     * @test A user can't save a note when no title
     * 
     * @return void
     */
    public function a_user_cant_save_note_with_no_title()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new NotesPage)
                ->saveNote()
                ->pause(500)
                ->assertMissing('.alert')
                ->assertSeeIn('.notes', 'No notes yet')
                ->assertDontSeeIn('.notes', 'You have 1 note')
                ->assertMissing('.notes ul li:nth-child(2)');
        });
    }
}