<?php

class UploadsController extends \BaseController {

	protected $validation_error_message = 'Validation Error.';
	protected $access_denied_message = 'Access denied.';
	protected $created_message = 'Record created.';
	protected $updated_message = 'Record updated.';
	protected $deleted_message = 'Record deleted.';
	protected $delete_error_message = 'Error deleting record.';

	/**
	 * Display a listing of uploads
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!Upload::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$users_under_me = Auth::user()->get_authorized_userids(Upload::$show_authorize_flag);
			if(empty($users_under_me)) {
				$uploads = Upload::whereNotNull('uploads.created_at');	
			} else {
				$uploads = Upload::whereIn('uploads.user_id', $users_under_me);	
			}
			$uploads = $uploads->select([
				'uploads.id',
        'uploads.name',
        'uploads.size',
        'uploads.url',
        'uploads.path',
        'uploads.type',

			]);
			return Datatables::of($uploads)
        ->add_column('actions', '{{View::make("uploads.actions-row", compact("id"))->render()}}')
				->remove_column('id')
				->make();
			return Datatables::of($uploads)->make();
		}
		$script_name = 'index';
		$style_name = 'index';
		return View::make('uploads.index', compact('script_name', 'style_name'));
	}

	/**
	 * Show the form for creating a new upload
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!Upload::canCreate())
		{
			return $this->_access_denied();
		}
		return View::make('uploads.create');
	}

	/**
	 * Store a newly created upload in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Upload::setRules('store');
		if(!Upload::canCreate())
		{
			return $this->_access_denied();
		}
		$upload = Upload::create(Input::all());
		if(!$upload->save())
		{
			return $this->_validation_error($upload);
		}
		if(Request::ajax())
		{
			return Response::json($upload->toJson(), 201);
		}
		return Redirect::route('uploads.index')
			->with('notification:success', $this->created_message);
	}

	/**
	 * Display the specified upload.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$upload = Upload::findOrFail($id);
		if(!$upload->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($upload);
		}
		$script_name = 'index';
		return View::make('uploads.show', compact('upload', 'script_name'));
	}

	/**
	 * Show the form for editing the specified upload.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$upload = Upload::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$upload->canUpdate())
		{
			return _access_denied();
		}
		return View::make('uploads.edit', compact('upload'));
	}

	/**
	 * Update the specified upload in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$upload = Upload::findOrFail($id);
		Upload::setRules('update');
		$data = Input::all();
		if(!$upload->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$upload->update($data)) {
			return $this->_validation_error($upload);
		}
		if(Request::ajax())
		{
			return $upload;
		}
		return Redirect::route('uploads.edit', $upload->id)
			->with('notification:success', $this->updated_message);
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
		if(!$upload->canDelete())
		{
			return $this->_access_denied();
		}
		$upload->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::route('uploads.index')
			->with('notification:success', $this->deleted_message);
	}

	/**
	 * Response Shorthands
	 */

	public function _ajax_denied()
	{
		return Response::json("Bad request", 400);
	}

	public function _access_denied()
	{
		if(Request::ajax())
		{
			return Response::json($this->access_denied_message, 403);
		}
		return Redirect::back()
			->with('notification:danger', $this->access_denied_message);
	}

	public function _validation_error($upload)
	{
		if(Request::ajax())
		{
			return Response::json($upload->validationErrors, 400);
		}
		return Redirect::back()
			->withErrors($upload->validationErrors)
			->withInput()
			->with('notification:danger', $this->validation_error_message);
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
