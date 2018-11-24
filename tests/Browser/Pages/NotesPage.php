<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class NotesPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/home';
    }
    
    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs('/home');
    }

    public function typeNote(Browser $browser, $title = null, $body = null)
    {
        $browser->type('@title', $title)
            ->type('@body', $body);
    }

    public function saveNote(Browser $browser)
    {
        $browser->press('Save');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@title' => 'input[id="title"]',
            '@body' => 'textarea[id="body"]',
        ];
    }
}
