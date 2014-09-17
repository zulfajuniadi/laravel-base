<?php

class OrganizationUnitsController extends \BaseController
{

    /**
     * Display a listing of organizationunits
     *
     * @return Response
     */
    public function index()
    {
        if (!OrganizationUnit::canList()) {
            return $this->_access_denied();
        }
        if (Request::ajax()) {
            $organization_units = OrganizationUnit::select(['organization_units.id', 'organization_units.name', DB::raw('parent.name as pname'), 'users.username'])
                ->leftJoin('users', 'organization_units.user_id', '=', 'users.id')
                ->leftJoin(DB::raw('organization_units as parent'), 'organization_units.parent_id', '=', 'parent.id')
                ->groupBy('organization_units.id');
            return Datatables::of($organization_units)
                ->add_column('actions', '{{View::make("organizationunits.actions-row", compact("id"))->render()}}')
                ->remove_column('id')
                ->make();
        }
        Asset::push('js', 'datatables');
        return View::make('organizationunits.index');
    }

    /**
     * Show the form for creating a new organizationunit
     *
     * @return Response
     */
    public function create()
    {
        if (Request::ajax()) {
            return _ajax_denied();
        }
        if (!OrganizationUnit::canCreate()) {
            return $this->_access_denied();
        }
        return View::make('organizationunits.create');
    }

    /**
     * Store a newly created organizationunit in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), OrganizationUnit::$rules['store']);
        if (!OrganizationUnit::canCreate()) {
            return $this->_access_denied();
        }
        if ($validator->fails()) {
            return $this->_validation_error($validator->messages());
        }
        $organizationunit = OrganizationUnit::create($data);
        if (!isset($organizationunit->id)) {
            return $this->_create_error();
        }
        $parent = OrganizationUnit::findOrFail($data['parent_id']);
        $organizationunit->makeChildOf($parent);
        $parent->touch();
        if (Request::ajax()) {
            return Response::json($organizationunit->toJson(), 201);
        }
        return Redirect::route('organizationunits.index')
            ->with('notification:success', $this->created_message);
    }

    /**
     * Display the specified organizationunit.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $organizationunit = OrganizationUnit::findOrFail($id);
        if (!$organizationunit->canShow()) {
            return $this->_access_denied();
        }
        if (Request::ajax()) {
            return $organizationunit;
        }
        Asset::push('js', 'show');
        return View::make('organizationunits.show', compact('organizationunit'));
    }

    /**
     * Show the form for editing the specified organizationunit.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $organizationunit = OrganizationUnit::find($id);
        if (Request::ajax()) {
            return _ajax_denied();
        }
        if (!$organizationunit->canUpdate()) {
            return $this->_access_denied();
        }
        return View::make('organizationunits.edit', compact('organizationunit'));
    }

    /**
     * Update the specified organizationunit in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $organizationunit = OrganizationUnit::findOrFail($id);
        if (!$organizationunit->canUpdate()) {
            return $this->_access_denied();
        }
        $validator = Validator::make($data = Input::all(), OrganizationUnit::$rules['update']);
        if ($validator->fails()) {
            return $this->_validation_error($validator->messages());
        }
        if (!$organizationunit->update($data)) {
            return $this->_update_error();
        }
        if ((int) $organizationunit->parent_id !== (int) $data['parent_id']) {
            $organizationunit->makeChildOf($data['parent_id']);
            self::find($data['parent_id'])->touch();
        }
        if (Request::ajax()) {
            return $organizationunit;
        }

        Session::remove('_old_input');
        return Redirect::route('organizationunits.edit', $id)
            ->with('notification:success', $this->updated_message);
    }

    /**
     * Remove the specified organizationunit from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $organizationunit = OrganizationUnit::findOrFail($id);
        if (!$organizationunit->canDelete()) {
            return $this->_access_denied();
        }
        if (!$organizationunit->delete()) {
            return $this->_delete_error();
        }
        if (Request::ajax()) {
            return Response::json($this->deleted_message);
        }
        return Redirect::route('organizationunits.index')
            ->with('notification:success', $this->deleted_message);
    }

    public function __construct()
    {
        parent::__construct();
        View::share('controller', 'OrganizationUnitsController');
    }
}
