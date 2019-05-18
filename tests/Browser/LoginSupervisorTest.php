<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginSupervisorTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginSupervisor(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'supervisor@gmail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertUrlIs("http://spd.test/supervisor/index");
        });
    }

}
