<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginKaryawanTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginKaryawan(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'karyawan@gmail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertUrlIs("http://spd.test/karyawan/index");
        });
    }

}
