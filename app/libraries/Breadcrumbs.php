<?php

// Example: 
// Breadcrumbs::push(action('TicketTypesController@show', $parent->id), $parent->name);

class Breadcrumbs
{

    private static $items = [];

    public static function push($url, $text)
    {
        self::$items[$url] = $text;
    }

    public static function pull($text)
    {
        $key = array_search($text, self::$items);
        if($key) {
            unset(self::$items[$key]);
        }
    }

    public static function render()
    {
        if(count(self::$items) === 0)
            return '';

        $str = '<ol class="breadcrumb">';
        $keys = array_keys(self::$items);
        $end = array_pop($keys);

        foreach (self::$items as $url => $item) {
            $active = '';
            if($url === $end)
                $active = ' class="active"';
            $str = $str . '<li' . $active . '><a href="' . $url . '">' . $item . '</a></li>';
        }
        return $str . '</ol>';
    }

}