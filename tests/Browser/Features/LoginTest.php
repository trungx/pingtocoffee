<?php

namespace Tests\Browser\Features;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test redirect after login.
     *
     * @throws \Throwable
     */
    public function testRedirectCorrectAfterLogin()
    {
        $user = $this->signUp();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new Login())
                ->type("email", $user->email)
                ->type("password", "secret")
                ->press("Log In")
                ->assertPathIs("/dashboard");
        });
    }

    /**
     * Test redirect after logout.
     *
     * @throws \Throwable
     */
    public function testRedirectCorrectAfterLogout()
    {
        // No need re-login because session still have after testRedirectCorrectAfterLogin.
        $this->browse(function (Browser $browser) {
            $browser->clickLink("Logout")
                ->assertPathIs("/login");
        });
    }
}
