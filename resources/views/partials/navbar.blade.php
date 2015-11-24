<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">{{ app('config')->get('app.name') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            {!! app('menu')
                ->handler('app')
                ->render('navbar-inline') !!}
            {!! app('menu')
                ->handler('admin')
                ->setTitle(trans('menu.site_admin'))
                ->render() !!}
            {!! app('menu')
                ->handler('language')
                ->addClass('navbar-right')
                ->setTitle(trans('menu.language'))
                ->render() !!}
            {!! app('menu')
                ->handler('auth')
                ->render() !!}
        </div>
    </div>
</nav>