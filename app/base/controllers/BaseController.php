<?php

class BaseController extends Controller
{

    protected $validation_error_message = 'Validation Error.';
    protected $access_denied_message    = 'Access denied.';
    protected $created_message          = 'Record created.';
    protected $create_error_message     = 'Error creating record.';
    protected $updated_message          = 'Record updated.';
    protected $update_error_message     = 'Error updating record.';
    protected $deleted_message          = 'Record deleted.';
    protected $delete_error_message     = 'Error deleting record.';

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    protected function _ajax_denied()
    {
        return Response::json("Bad request", 400);
    }

    /**
     * Response Shorthands
     */

    protected function _access_denied()
    {
        if (Request::ajax()) {
            return Response::json($this->access_denied_message, 403);
        }
        return Redirect::back()
            ->with('notification:danger', $this->access_denied_message);
    }

    protected function _validation_error($obj)
    {
        $validationErrors = (is_subclass_of($obj, 'LaravelBook\Ardent\Ardent'))
        ?$obj->validationErrors
        :$obj;
        if (Request::ajax()) {
            return Response::json($validationErrors, 400);
        }
        Session::remove('_old_input');
        return Redirect::back()
            ->withErrors($validationErrors)
            ->withInput()
            ->with('notification:danger', $this->validation_error_message);
    }

    protected function _create_error()
    {
        if (Request::ajax()) {
            return Response::json($this->create_error_message, 400);
        }
        return Redirect::back()
            ->with('notification:danger', $this->create_error_message);
    }

    protected function _update_error()
    {
        if (Request::ajax()) {
            return Response::json($this->update_error_message, 400);
        }
        return Redirect::back()
            ->with('notification:danger', $this->update_error_message);
    }

    protected function _delete_error()
    {
        if (Request::ajax()) {
            return Response::json($this->delete_error_message, 400);
        }
        return Redirect::back()
            ->with('notification:danger', $this->delete_error_message);
    }

    protected function __construct()
    {
        View::share('controller', '');
    }

}
