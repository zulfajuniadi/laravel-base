<?php

class UploadsController extends \BaseController {

    /**
     * Store a newly created upload in storage.
     *
     * @return Response
     */
    public function store() 
    {
        Upload::setRules('store');
        if (!Upload::canCreate()) {
            return $this->_access_denied();
        }

        $file         = Input::file('file');
        $hash         = md5(microtime().time());
        $data         = [];
        $data['path'] = public_path().'/uploads/'.$hash.'/';
        mkdir($data['path']);
        $data['url']             = url('uploads/'.$hash);
        $data['name']            = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientOriginalName());
        $data['type']            = $file->getMimeType();
        $data['size']            = $file->getSize();
        $data['uploadable_type'] = Request::header('X-Uploader-Class');
        $data['uploadable_id']   = (Request::header('X-Uploader-Id')) ? Request::header('X-Uploader-Id') : 0;
        $data['token']           = Request::header('X-CSRF-Token');
        $file->move($data['path'], $data['name']);
        if (property_exists($data['uploadable_type'], 'generate_image_thumbnails')) {
            Queue::push('ThumbnailService', array('path' => $data['path'].'/'.$data['name']));
        }
        $upload = new Upload;
        $upload->fill($data);
        if (!$upload->save()) {
            return $this->_validation_error($upload);
        }
        if (Request::ajax()) {
            return Response::json($upload, 201);
        }
        return Redirect::back()
            ->with('notification:success', $this->created_message);
    }

    /**
     * Remove the specified upload from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) 
    {
        $upload = Upload::findOrFail($id);
        if (!$upload->canDelete()) {
            return $this->_access_denied();
        }
        File::deleteDirectory($upload->path);
        $upload->delete();
        if (Request::ajax()) {
            return Response::json($this->deleted_message);
        }
        return Redirect::back()
            ->with('notification:success', $this->deleted_message);
    }

    public function remove($id) 
    {
        $upload = Upload::findOrFail($id);
        if (!$upload->canDelete()) {
            return $this->_access_denied();
        }
        File::deleteDirectory($upload->path);
        $upload->delete();
        return Redirect::back()
            ->with('notification:success', $this->deleted_message);
    }

    /**
     * Custom Methods. Dont forget to add these to routes: Route::get('example/name', 'ExampleController@getName');
     */

    // public function getName()
    // {
    // }

    /**
     * Constructor
     */

    public function __construct() 
    {
        parent::__construct();
        View::share('controller', 'Upload');
    }

}
