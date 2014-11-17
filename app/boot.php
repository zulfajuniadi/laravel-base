<?php

Asset::push('js', 'application');
Asset::push('css', 'application');
if(Session::has('errors'))
{
    foreach(Session::get('errors')->all() as $message) {
        Log::error($message);
    }
}

/* Clean Clockwork Temporary Files */
$files = glob(storage_path() . '/clockwork/*.json');
$time  = time();

foreach ($files as $file)
if (is_file($file))
  if ($time - filemtime($file) >= 300) // 5 Minutes
    unlink($file);
