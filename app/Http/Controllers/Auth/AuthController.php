<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
     */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => app('config')->get('auth.password.rules') . '|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return UsersRepository::create(new User, [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function authenticated($request, $user)
    {
        if ($blacklist = $user->getActiveBlacklist()) {
            app('auth')->logout();
            return redirect()->action('Auth\AuthController@getLogin')
                ->with('danger', trans('users.blacklisted_until', ['until' => $blacklist->until]));
        }
        if (!$user->is_active) {
            app('auth')->logout();
            return redirect()->action('Auth\AuthController@getLogin')
                ->with('danger', trans('users.login_not_active'));
        }
        return redirect()->intended($this->redirectTo);
    }
}
