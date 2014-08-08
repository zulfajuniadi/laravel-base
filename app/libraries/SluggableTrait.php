<?php

use Illuminate\Support\Str;

trait SluggableTrait
{
  public function setSlug($name = null)
  {
    $name = (isset($this->$name)) ? $this->$name : $this->name;
    $slug = Str::slug($name);
    $nos = static::where('slug', '=', $slug)->count();
    if($nos > 0) {
      $slug = $slug . '-' . ($nos + 1);
    }
    $this->slug = $slug;
    $this->save();
    return $this;
  }
}