<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
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
            ->assertValue('#title', '')
            ->assertValue('#body', '');
        });
    }

    /**
     * @test A user can save a new note
     * 
     * @return void
     */
    // public function a_user_can_save_a_new_note()
    // {
    //     $this->browse(function (Browser $browsser) {
    //         //
    //     });
    // }

    /**
     * @test A user can see the word count of their note
     * 
     * @return void
     */
    // public function a_user_can_see_the_word_count_of_their_note()
    // {
    //     $this->browse(function (Browser $browsser) {
    //         //
    //     });
    // }

    /** 
     * @test A user can start a fresh note
     * 
     * @return void
     */
    // public function a_user_can_start_a_fresh_note()
    // {
    //     $this->browse(function (Browser $browsser) {
    //         //
    //     });
    // }
}