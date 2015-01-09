<?php

class Asset
{
    private static $queued = [
    'css' => [],
    'js'  => []
    ];

    public static function push($type, $path)
    {
        array_push(self::$queued[$type], $path);
    }

    public static function unshift($type, $path)
    {
        array_unshift(self::$queued[$type], $path);
    }

    public static function tags($type)
    {
        $returnString = '';
        $min = '.min';
        if (App::environment('local'))
        {
            $min = '';
        }
        foreach (self::$queued[$type] as $path) {
            if($type === 'js')
            {
                $returnString =  $returnString . '      <script src="/assets/javascripts/' . $path . $min . '.js"></script>'."\n";
            }
            else
            {
                $returnString = $returnString . '      <link rel="stylesheet" href="/assets/stylesheets/' . $path . $min . '.css"/>'."\n";
            }
        }
        return $returnString;
    }
}