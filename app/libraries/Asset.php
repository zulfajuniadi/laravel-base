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
    foreach (self::$queued[$type] as $path) {
      if($type === 'js')
      {
        $returnString =  $returnString . '      ' . javascript_include_tag($path) . "\n";
      }
      else
      {
        $returnString = $returnString . '      ' .  stylesheet_link_tag($path) . "\n";
      }
    }
    return $returnString;
  }
}