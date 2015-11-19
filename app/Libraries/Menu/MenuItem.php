<?php

namespace App\Libraries\Menu;

class MenuItem
{

    public $class = '';
    public $title = 'title';
    public $link = '/';
    public $target = '_self';

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function render()
    {
        return '<a href="' . $this->link . '" class="' . $this->class . '" target="' . $this->target . '">' . $this->title . '</a>';
    }

    public function __toString()
    {
        return $this->render();
    }

    public function __construct($link, $title, $class = '', $target = '_self')
    {
        $this->class = $class;
        $this->title = $title;
        $this->link = $link;
        $this->target = $target;
    }
}