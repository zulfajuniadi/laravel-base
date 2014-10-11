<?php

/**
 */

class PermissionsTest extends TestCase
{

    public $user;
    public $permission;
    public $route = 'permissions';

    public function getUser()
    {
        $this->user = User::where('username', 'admin')->first();
        $this->be($this->user);
    }

    public function getPermission()
    {
        $this->getUser();
        $this->permission = Permission::where('name', 'TestPermission')->first();
    }

    public function testIndex()
    {
        $this->getUser();
        $this->route('GET', $this->route . '.index');
        $this->assertResponseOk();
    }

    public function testAjaxIndex()
    {
        $this->getUser();
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $response = $this->route('GET', $this->route . '.index');
        json_decode($response->getContent());
        $this->assertResponseOk();
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    public function testCreate()
    {
        $this->getUser();
        $this->route('GET', $this->route . '.create');
        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->getUser();
        $this->route('POST', $this->route . '.store', [
            'group_name'   => 'Test',
            'name'         => 'TestPermission',
            'display_name' => 'Test Permission'
            ]);
        $this->assertEquals(FALSE, Session::has('errors'));
        $this->assertRedirectedToRoute($this->route . '.index');
    }

    public function testShow()
    {
        $this->getPermission();
        $this->route('GET', $this->route . '.show', ['permission_id' => $this->permission->id]);
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->getPermission();
        $this->route('GET', $this->route . '.edit', ['permission_id' => $this->permission->id]);
        $this->assertResponseOk();
    }

    public function testUpdate()
    {
        $this->getPermission();
        $this->route('PUT', $this->route . '.update', [
            'id'           => $this->permission->id,
            'group_name'   => 'Test',
            'name'         => 'TestPermission',
            'display_name' => 'Test Permissions'
            ]);
        $this->assertEquals(FALSE, Session::has('errors'));
        $this->assertRedirectedToRoute($this->route . '.edit', ['id' => $this->permission->id]);
    }

    public function testDelete()
    {
        $this->getPermission();
        $this->route('DELETE', $this->route . '.destroy', ['id' => $this->permission->id]);
        $this->assertEquals(FALSE, Session::has('errors'));
        $this->assertRedirectedToRoute($this->route . '.index');
    }
}