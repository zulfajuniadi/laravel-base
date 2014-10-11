<?php

/**
 */

class RolesTest extends TestCase
{

    public $user;
    public $role;
    public $route = 'roles';

    public function getUser()
    {
        $this->user = User::where('username', 'admin')->first();
        $this->be($this->user);
    }

    public function getRole()
    {
        $this->getUser();
        $this->role = Role::where('name', 'Test Role')->first();
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
        $this->route('POST', $this->route . '.store', ['name' => 'Test Role']);
        $this->assertEquals(FALSE, Session::has('errors'));
        $this->assertRedirectedToRoute($this->route . '.index');
    }

    public function testShow()
    {
        $this->getRole();
        $this->route('GET', $this->route . '.show', ['role_id' => $this->role->id]);
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $this->getRole();
        $this->route('GET', $this->route . '.edit', ['role_id' => $this->role->id]);
        $this->assertResponseOk();
    }

    public function testUpdate()
    {
        $this->getRole();
        $this->route('PUT', $this->route . '.update', ['id' => $this->role->id, 'name' => 'Test Role']);
        $this->assertEquals(FALSE, Session::has('errors'));
        $this->assertRedirectedToRoute($this->route . '.edit', ['id' => $this->role->id]);
    }

    public function testDelete()
    {
        $this->getRole();
        $this->route('DELETE', $this->route . '.destroy', ['id' => $this->role->id]);
        $this->assertEquals(FALSE, Session::has('errors'));
        $this->assertRedirectedToRoute($this->route . '.index');
    }
}