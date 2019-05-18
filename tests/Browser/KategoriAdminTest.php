<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class KategoriAdminTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertUrlIs("http://spd.test/admin/index");
                    //->assertSee('Administrator');
        });     
    }

    public function testKategoriVisitAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kategori')
                    ->assertSee('Kategori');
        });     
    }

    public function testKategoriInsertAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/kategori')
                    ->type('namakategori', 'Dokumen Rahasia')
                    ->press('Simpan')
                    ->assertSee('Dokumen Rahasia');
        });     
    }    
}
