<?php

trait UploadableTrait
{
    public function uploads()
    {
        return $this->morphMany('Upload', 'uploadable');
    }

    /**
    * Display the multifile uploader form
    * @param  integer $size maximum file size (Megabytes)
    * @param  string  $type accepted file types that can be in any of these format: image/*,application/pdf,.psd
    * @param  integer $files maximum files uploader can handle
    * @return Laravel View Instance
    */
    public function multiUploader($size = 2, $type = 'image/*', $files = null) 
    {
        $class = get_class($this);
        $id = $this->id;
        return View::make('uploads.multi', compact('class', 'id', 'size', 'type', 'files'));
    }

    /**
    * Display the single uploader form
    * @param  integer $size maximum file size (Megabytes)
    * @param  string  $type accepted file types that can be in any of these format: image/*,application/pdf,.psd
    * @param  integer $files maximum files uploader can handle
    * @return Laravel View Instance
    */
    public function singleUploader($size = 2, $type = 'image/*', $files = null) 
    {
        $class = get_class($this);
        $id = $this->id;
        return View::make('uploads.single', compact('class', 'id', 'size', 'type', 'files'));
    }

    /**
    * Display the multifile uploader form
    * @param  integer $size maximum file size (Megabytes)
    * @param  string  $type accepted file types that can be in any of these format: image/*,application/pdf,.psd
    * @param  integer $files maximum files uploader can handle
    * @return Laravel View Instance
    */
    public static function advanceMultiUploader($size = 2, $type = 'image/*', $files = null) 
    {
        $class = __CLASS__;
        return View::make('uploads.multi', compact('class', 'size', 'type', 'files'));
    }

    /**
    * Display the single uploader form
    * @param  integer $size maximum file size (Megabytes)
    * @param  string  $type accepted file types that can be in any of these format: image/*,application/pdf,.psd
    * @param  integer $files maximum files uploader can handle
    * @return Laravel View Instance
    */
    public static function advanceSingleUploader($size = 2, $type = 'image/*') 
    {
        $class = __CLASS__;
        return View::make('uploads.single', compact('class', 'size', 'type'));
    }

    public function uploadsTable()
    {
        $uploads = $this->uploads;
        return View::make('uploads.show', compact('uploads'));
    }

    public function associateAdvancedUploads()
    {
        $class = get_class($this);
        $uploads = Upload::where('uploadable_type', $class)
            ->where('uploadable_id', 0)
            ->where('token', csrf_token())
            ->update(['uploadable_id' => $this->id]);
    }
} 
