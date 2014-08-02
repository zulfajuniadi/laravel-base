<h1>{{ Lang::get('confide::confide.email.password_reset.subject') }}</h1>

<p>{{ Lang::get('confide::confide.email.password_reset.greetings', array( 'name' => $user->username)) }},</p>

<p>{{ Lang::get('confide::confide.email.password_reset.body') }}</p>
<a href='{{{ (Confide::checkAction('AuthController@reset_password', array($token))) ? : URL::to('auth/reset/'.$token)  }}}'>
    {{{ (Confide::checkAction('AuthController@reset_password', array($token))) ? : URL::to('auth/reset/'.$token)  }}}
</a>

<p>{{ Lang::get('confide::confide.email.password_reset.farewell') }}</p>
