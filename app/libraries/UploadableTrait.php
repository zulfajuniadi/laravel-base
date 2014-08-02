<?php

trait UploadableTrait
{
  function uploads()
  {
    return $this->morphMany('Upload', 'uploadable');
  }
} 