<?php

/*
|--------------------------------------------------------------------------
| Confide Controller Template
|--------------------------------------------------------------------------
|
| This is the default Confide controller template for controlling user
| authentication. Feel free to change to your needs.
|
 */

class AuthController extends BaseController
{

    public function index()
    {
        return View::make('users.index');
    }

    /**
     * Displays the form for account creation
     *
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'));
    }

    /**
     * Stores new account
     *
     */
    public function store()
    {
        $user = new User;

        $user->first_name = Input::get('first_name');
        $user->last_name  = Input::get('last_name');
        $user->username   = Input::get('username');
        $user->email      = Input::get('email');
        $user->password   = Input::get('password');

        User::setRules('store');

        // Hacky workaround for: https://github.com/laravelbook/ardent/issues/152
        if(app()->env === 'testing') {
            unset(User::$rules['password_confirmation']);
            unset(User::$rules['password']);
        } else {
            $user->password_confirmation = Input::get('password_confirmation');
        }

        $user->save();

        if ($user->getKey()) {
            $notice = Lang::get('confide::confide.alerts.account_created').' '.Lang::get('confide::confide.alerts.instructions_sent');
            $user->roles()->sync([6]);
            // Redirect with success message, You may replace "Lang::get(..." for your custom message.
            return Redirect::action('AuthController@login')
                ->with('notice', $notice);
        } else {
            // Get validation errors (see Ardent package)
            $error = $user->errors()->all(':message');

            return Redirect::action('AuthController@create')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }
    }

    /**
     * Displays the login form
     *
     */
    public function login()
    {
        if (Confide::user()) {
            // If user is logged, redirect to internal
            // page, change it to '/admin', '/dashboard' or something
            return Redirect::to('/');
        } else {
            return View::make(Config::get('confide::login_form'));
        }
    }

    /**
     * Attempt to do login
     *
     */
    public function doLogin()
    {
        $input = array(
            'email'    => Input::get('email'), // May be the username too
            'username' => Input::get('email'), // so we have to pass both
            'password' => Input::get('password'),
            'remember' => Input::get('remember'),
        );

        // If you wish to only allow login from confirmed users, call logAttempt
        // with the second parameter as true.
        // logAttempt will check if the 'email' perhaps is the username.
        // Get the value from the config file instead of changing the controller
        if (Confide::logAttempt($input, Config::get('confide::signup_confirm'))) {
            // Redirect the user to the URL they were trying to access before
            // caught by the authentication filter IE Redirect::guest('user/login').
            // Otherwise fallback to '/'
            // Fix pull #145
            return Redirect::intended('/');// change it to '/admin', '/dashboard' or something
        } else {
            $user = new User;

            // Check if there was too many login attempts
            if (Confide::isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($user->checkUserExists($input) and !$user->isConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('AuthController@login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param    string  $code
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('AuthController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('AuthController@login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function forgotPassword()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('AuthController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('AuthController@forgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
            ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     */
    public function doResetPassword()
    {
        $input = array(
            'token'                 => Input::get('token'),
            'password'              => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
        );

        User::setRules('emailResetPassword');

        // By passing an array with the token, password and confirmation
        if (Confide::resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('AuthController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('AuthController@resetPassword', array('token' => $input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

    public function __construct()
    {
        parent::__construct();
        View::share('controller', 'AuthController');
        Asset::push('js', 'login');
        Asset::push('css', 'login');
    }

}
