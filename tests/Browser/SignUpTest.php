<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\SignUpPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignUpTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * @test A user can sign up
     *
     * @return void
     */
    public function a_user_can_sign_up()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new SignUpPage)
                ->signUp('Tabby Garett', 'tabby@codecourse.com', 'password', 'password')
                ->assertPathIs('/home')
                ->assertSeeIn('.navbar', 'Tabby Garett');
        });
    }
}
