<?php

namespace App\Libraries\Menu;

use Illuminate\Support\Collection;
use ReflectionClass;

class MenuHandler extends Collection
{

    protected $title = 'Menu';
    protected $class = '';
    protected $type = 'navbar';

    public function findItem($name)
    {
        $item = $this->filter(function() use ($name){ 
            return $item->name == $name; 
        })->first();
        return $item;
    }

    public function removeItem($name)
    {
        $this->items = $this->filter(function() use ($name){ 
            return $item->name != $name; 
        });
        return $this;
    }

    public function addItem()
    {
        $this->push((new ReflectionClass(MenuItem::class))->newInstanceArgs(func_get_args()));
        return $this;
    }

    public function addItemIf()
    {
        $arguments = func_get_args();
        if(array_shift($arguments)) {
            return call_user_func_array([$this, 'addItem'], $arguments);
        }
        return $this;
    }

    public function addItemIfNot()
    {
        $arguments = func_get_args();
        if(!array_shift($arguments)) {
            return call_user_func_array([$this, 'addItem'], $arguments);
        }
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function addClass($class)
    {
        $this->class .= ' ' . $class;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function render($type = null)
    {
        if($type)
            $this->type = $type;
        if($this->count() == 0)
            return '';
        switch ($this->type) {
            case 'navbar':
                $this->class .= ' nav navbar-nav';
                return '<ul class="' . $this->class . '"><li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $this->title . ' <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        ' . $this->reduce(function($carry, $current){
        $active = (app('request')->url() == $current->link) ? 'active' : '';
        return $carry . '<li class="' . $active . '">' . $current->render() . '</li>';
    }, '') . '
    </ul>
</li></ul>';
                break;
            case 'navbar-inline':
                $this->class .= ' nav navbar-nav';
                return '<ul class="' . $this->class . '">' . $this->reduce(function($carry, $current){
        $active = (app('request')->url() == $current->link) ? 'active' : '';
        return $carry . '<li class="' . $active . '">' . $current->render() . '</li>';
    }, '') . '
    </ul>';
                break;
            case 'dropdown':
                $this->class .= ' dropdown-toggle';
                return '<div class="btn-group">
                    <button type="button" class="' . $this->class . ' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">' . $this->reduce(function($carry, $current){
        $active = (app('request')->url() == $current->link) ? 'active' : '';
        return $carry . '<li class="' . $active . '">' . $current->render() . '</li>';
    }, '') . '</ul>
                </div>';
                break;
            case 'breadcrumbs':
                $this->class .= ' breadcrumb';
                return '<ol class="' . $this->class . '">' . $this->reduce(function($carry, $current){
        $active = (app('request')->url() == $current->link) ? 'active' : '';
        return $carry . '<li class="' . $active . '">' . $current->render() . '</li>';
    }, '') . '</ol>';
                break;
            case 'inline':
                $this->class .= ' list-inline list-unstyled';
                return '<ul class="' . $this->class . '">' . $this->reduce(function($carry, $current){
        $active = (app('request')->url() == $current->link) ? 'active' : '';
        return $carry . '<li class="' . $active . '">' . $current->render() . '</li>';
    }, '') . '</ul>';
                break;
        }
    }

    public function __toString()
    {
        return $this->render('navbar');
    }

}