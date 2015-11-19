<!-- resources/views/emails/password.blade.php -->

{{trans('auth.click_here_reset_password')}}: <a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a>