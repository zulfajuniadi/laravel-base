<?php

Asset::push('js', 'application');
Asset::push('css', 'application');
if(Session::has('errors'))
{
    foreach(Session::get('errors')->all() as $message) {
        Log::error($message);
    }
}