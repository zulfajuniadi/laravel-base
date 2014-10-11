<?php

class AuthTest extends TestCase {

    public $user;
    public $reminder;

    public function testBootup()
    {
        Artisan::call('db:seed', ['--class' => 'TestSeeder']); 
        Mail::pretend(true);
    }

    public function getUser()
    {
        $this->user = User::where('username', 'testuser')->first();
    }

    public function getReminder()
    {
        $this->getUser();
        $this->reminder = DB::table('password_reminders')->where('email', $this->user->email)->first();
    }

    public function testRegistrationPage()
    {
        $this->action('GET', 'AuthController@create');
        $this->assertResponseOk();
    }

    public function testRegistration()
    {
        User::where('username', 'testuser')->delete();
        $this->action('POST', 'AuthController@store', [
            'first_name'            => 'Unit',
            'last_name'             => 'Test',
            'username'              => 'testuser',
            'email'                 => 'testuser@example.com',
            'password'              => 'testuser',
            'password_confirmation' => 'testuser'
        ]);
        $this->assertRedirectedToAction('AuthController@login');
        User::$rules = [];
        $this->getUser();
        $this->user->confirmation_code = md5( uniqid(mt_rand(), true));
        $this->user->save();
    }

    public function testConfirmation()
    {
        $this->getUser();
        $this->action('GET', 'AuthController@confirm', ['code' => $this->user->confirmation_code]);
        $this->assertRedirectedToAction('AuthController@login');
        $this->getUser();
        $this->assertEquals('1', $this->user->confirmed);
    }

    public function testLoginPage()
    {
        $this->action('GET', 'AuthController@login');
        $this->assertResponseOk();
    }

    public function testLoginWithUsername()
    {
        $this->getUser();
        $action = $this->action('POST', 'AuthController@doLogin', array('email' => $this->user->email, 'password' => 'testuser'));
        $this->assertRedirectedTo('/');
    }

    public function testLoginWithEmail()
    {
        $this->getUser();
        $action = $this->action('POST', 'AuthController@doLogin', array('email' => $this->user->username, 'password' => 'testuser'));
        $this->assertRedirectedTo('/');
    }

    public function testForgotPasswordPage()
    {
        $this->action('GET', 'AuthController@forgotPassword');
        $this->assertResponseOk();
    }

    public function testForgotPassword()
    {
        $this->getUser();
        $this->action('POST', 'AuthController@doForgotPassword', ['email' => $this->user->email]);
        $this->assertEquals(false, Session::has('error'));
        $this->assertRedirectedToAction('AuthController@login');
    }

    public function testResetPasswordPage()
    {
        $this->getReminder();
        $this->action('GET', 'AuthController@resetPassword', ['token' => $this->reminder->token]);
        $this->assertResponseOk();
    }

    public function testResetPassword()
    {
        $this->getReminder();
        $this->action('POST', 'AuthController@doResetPassword', [
            'token'                 => $this->reminder->token,
            'password'              => 'newpassword',
            'password_confirmation' => 'newpassword' ]);
        $this->assertRedirectedToAction('AuthController@login');
        $this->assertEquals(true, Session::has('notice'));
    }

    public function testLoginWithUsernameAfterResetPassword()
    {
        $this->getUser();
        $action = $this->action('POST', 'AuthController@doLogin', array('email' => $this->user->email, 'password' => 'newpassword'));
        $this->assertRedirectedTo('/');
    }

}
