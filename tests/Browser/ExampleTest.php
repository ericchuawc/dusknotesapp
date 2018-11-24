<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignInTest extends DuskTestCase
{
    /**
     * @test A user can sign in
     *
     * @return void
     */
    public function a_user_can_sign_in()
    {
        $user = factory(User::class)->create([
            'email' => 'megaman8199@hotmail.com',
            'password' => bcrypt('password'),
            'name' => 'Mega Man'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('#email', $user->email)
                ->type('#password', 'password')
                ->press('Login')
                ->assertPathIs('/home')
                ->assertSeeIn('.navbar', $user->name);
        });
    }
}
