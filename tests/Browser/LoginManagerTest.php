<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginManagerTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginManager(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'manager@gmail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertUrlIs("http://spd.test/manager/index");
        });
    }

}
