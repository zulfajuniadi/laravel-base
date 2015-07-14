<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class Registration extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $this->visit('/auth/register')
             ->see(trans('auth.registration.user_registration'))
             ->type('zulfajuniadi@gmail.com', 'email')
             ->type('zulfa', 'username')
             ->type('Zulfa Juniadi bin Zulkifli', 'name')
             ->type('1q2w3e4r!@#', 'password')
             ->type('1q2w3e4r!@#', 'confirm_password')
             ->press(trans('auth.registration.register'))
             ->see(trans('auth.registration.successful'))
             ->onPage('/auth/login')
             ;
    }

    public function testValidation()
    {
        $user = User::where('email', 'zulfajuniadi')
        $this->visit('/auth/register')
             ->see('hello');
    }

}
