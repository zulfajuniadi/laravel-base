<?php

trait UploadableTrait
{
  public function uploads()
  {
    return $this->morphMany('Upload', 'uploadable');
  }

  /**
   * Display the uploader form
   * @param  integer $size maximum file size (Megabytes)
   * @param  string  $type accepted file types that can be in any of these format: image/*,application/pdf,.psd
   * @param  integer $files maximum files uploader can handle
   * @return Laravel View Instance
   */
  public function yieldUploader($size = 2, $type = 'image/*', $files = null) 
  {
    $class = get_class($this);
    $id = $this->id;
    return View::make('uploads.create', compact('class', 'id', 'size', 'type', 'files'));
  }

  public function yieldUploadsTable()
  {
    $uploads = $this->uploads;
    return View::make('uploads.show', compact('uploads'));
  }
} 
